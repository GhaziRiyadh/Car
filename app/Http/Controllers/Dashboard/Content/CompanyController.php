<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class CompanyController extends Controller
{
    public static function getCompany($id = null, $name = null): \Illuminate\Support\Collection
    {
        $company = Company::with('cars:id,name')
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->get(['id', 'name'])->toArray();

        return collect($company)->map(function ($v) {
            return [
                'id' => $v['id'],
                'name' => $v['name'],
                'cars' => $v['cars'],
            ];
        });
    }

    public function store(Request $request)
    {
        $store = Company::create(self::setValidation($request));

        return self::getCompany($store->id)->toJson();
    }

    public function update(Request $request, Company $company)
    {
        $company->update(self::setValidation($request));

        return self::getCompany($company->id)->toJson();
    }

    public function delete(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted']);
    }

    public static function setValidation(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:50',
        ]);
    }
}
