<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Company;
use Illuminate\Http\Request;

class FlutterAppController extends Controller
{
    public function getAllCompanies()
    {
        $companies=Company::get()->toArray();
        return response()->json($companies);
    }

    public function getCompanyCars (Request $request)
    {
        $cars=Car::where('company_id',$request->id)->get(['id','name'])->toArray();
        return response()->json($cars);

    }
}
