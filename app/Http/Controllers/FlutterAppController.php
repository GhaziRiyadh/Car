<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $search = Product::with(['quality', 'image'])
            ->whereHas('car', fn ($query) => $query->where('id', '=', $request->carID)->whereRelation('company', 'id', '=', $request->companyID))
            ->when($request->piece_number, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->get()
            ->map(fn ($v) => [
                'id' => $v->id,
                'name' => $v->name,
                'price' => $v->price,
                'quality' => $v?->quality?->name,
                'piece_number' => $v?->piece_number,
                'image' => $v?->image?->path,
            ]);

        return response()->json($search);
    }
}
