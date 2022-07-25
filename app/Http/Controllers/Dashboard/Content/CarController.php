<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class CarController extends Controller
{
    public static function getCars($id = null, $name = null)
    {
        $cars = Car::with('company:id,name')
            ->when($id, fn ($q, $id) => $q->where('id', $id))
            ->when($name, fn ($q, $name) => $q->where('name', 'like', '%' . $name . '%'))
            ->get()
            ->toArray();

        return collect($cars)
            ->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'company' => $v['company']['name'] ?? null,
                    'color' => $v['color'],
                    'year' => $v['year'],
                    'model' => $v['model'],
                    'oil_type' => $v['oil_type'],
                    'motor_type' => $v['motor_type'],
                ];
            });
    }

    public function store(Request $request): JsonResponse
    {
        $car = Car::query()->create(self::setValidation($request));

        return response()->json(self::getCars(id: $car->id));
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update(self::setValidation($request));

        return response()->json(self::getCars(id: $car->id));
    }

    public function delete(Car $car): JsonResponse
    {
        $car->delete();

        return response()->json([
            'message' => 'Car deleted',
        ]);
    }

    public static function setValidation(Request $request): array
    {
        return $request->validate([
            'name' => 'required:string|max:255',
            'company_id' => 'required:exists:companies,id',
            'model' => 'required|integer|min:1940|max:' . Carbon::now()->year,
            'year' => 'required|integer|min:1940|max:' . Carbon::now()->year,
            'color' => 'required:string|max:255',
            'motor_type' => 'required:string|max:255',
            'oil_type' => 'required|in:بترول,ديزل',
        ]);
    }
}
