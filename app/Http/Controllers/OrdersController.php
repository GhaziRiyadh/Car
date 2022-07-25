<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bills;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class OrdersController extends Controller
{

    public function getBillsFunction($bill, $result)
    {
        $result = [];
        foreach ($bill as $item) {

            $item['locationName'] = $item['location']['locationName'];
            $item['description'] = $item['location']['description'];
            $item['long'] = $item['location']['long'];
            $item['lat'] = $item['location']['lat'];

            $item['status'] = $item['statuses']['status'];

            unset($item['location']);
            unset($item['statuses']);


            $result[] = $item;
        }

        return $result;
    }

    public function getCustomerOrders(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->api_token);
        $customer = $token->tokenable;
        $bill = Bills::with(['orders', 'statuses', 'location'])
            ->where('customer_id', $customer->id)->get()->toArray();
        $result = [];
        $result = $this->getBillsFunction($bill, $result);

        // dd($result);
        return response()->json($result);
    }

    public function addNewOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->user();

            $token = PersonalAccessToken::findToken($request->api_token);
            $customer = $token->tokenable;

            $orders = collect(json_decode($request->get('orders')));


            $bill = Bill::create([
                'seller_id' => $user->id,
            'payer_id' => User::find(1),
            'status_id' => $request,
            'payment_method' => $request,
            'confirm_code' => $request,
            'date' => $request,
            'total' => $request,
            ]);

            foreach ($orders as $order) {
                $bill->orders()->create(collect($order)->toArray());
            }

            DB::commit();
            return response()->json('تم إرسال الطلب بنجاح.');
        } catch (Exception | Error $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }
}
