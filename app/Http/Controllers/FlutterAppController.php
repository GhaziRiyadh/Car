<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Car;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class FlutterAppController extends Controller
{
    public function getAllCompanies()
    {
        $companies = Company::get()->toArray();
        return response()->json($companies);
    }

    public function getAllCompaniesProducts(Request $request)
    {

        $companies = Company::find($request->companyID);
        $cars = $companies->cars()->get();
        $products = $cars->map(fn ($v) => $v->products()->with(['quality', 'image'])->get()->map(function ($v) {
            return [
                'id' => $v->id,
                'name' => $v->name,
                'price' => $v->price,
                'quality' => $v?->quality?->name,
                'piece_number' => $v?->piece_number,
                'image' => $v?->image?->path,
            ];
        }));
        return response()->json(collect($products)->collapse()->toArray());
    }

    public function getCompanyCars(Request $request)
    {
        $cars = Car::where('company_id', $request->companyID)->get(['id', 'name'])->toArray();
        return response()->json($cars);
    }

    public function search(Request $request)
    {
        $name = $request->name == 'null' ? null : $request->name;
        $search = Product::with([
            'quality',
            'image'
        ])->whereHas(
            'car',
            function ($query) use ($request) {
                return $query
                    ->whereRelation('company', 'id', '=', $request->companyID)
                    ->where('id',  $request->carID)
                    ->where('year',  intval($request->model));
            }
        )
            ->when(
                $name,
                fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%')
            )
            ->get()->map(
                fn ($v) => [
                    'id' => $v->id,
                    'name' => $v->name,
                    'price' => $v->price,
                    'quality' => $v?->quality?->name,
                    'piece_number' => $v?->piece_number,
                    'image' => $v?->image?->path,
                ]
            );

        return response()->json($search);
    }

    public function userBills(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->api_token);
        $user = $token->tokenable;
        $bills = $user->sellerBill()->get()
            ->map(
                fn ($v) => [
                    'id' => $v->id,
                    'total' => $v->total,
                    'date' => $v->date,
                    'status' => $v->status()->first()?->name,
                    'order' => $v?->products()->get()?->map(fn ($v) => [
                        'id' => $v->id,
                        'quality' => $v?->quality?->name,
                        'name' => $v?->name,
                        'price' => $v?->price,
                        'piece_number' => $v?->piece_number,
                    ]),
                ]
            );
        return response()->json($bills);
    }

    public function addNewOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $token = PersonalAccessToken::findToken($request->api_token);
            $user = $token->tokenable;

            $orders = collect(json_decode($request->get('orders')));

            $total = 0;
            foreach ($orders as $order)
                $total += intval(collect($order)->toArray()['price']);


            $bill = Bill::create(
                [
                    'seller_id' => $user->id,
                    'payer_id' => User::find(1)?->id,
                    'status_id' => 1,
                    'payment_method' => '',
                    'confirm_code' => null,
                    'date' => $request->date,
                    'total' => $total,
                ]
            );

            foreach ($orders as $order)
                $bill->products()->attach(collect($order)->toArray()['id']);


            DB::commit();
            return response()->json('تم إرسال الطلب بنجاح.');
        } catch (Exception | Error $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }
}
