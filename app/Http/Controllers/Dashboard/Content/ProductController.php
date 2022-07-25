<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Collection;

class ProductController extends Controller
{
    public static function getProducts($id = null, $name = null)
    {
        $products = Product::with([
            'car:id,name',
            'quality:id,name',
            'image',
        ])->when($id, fn ($q, $id) => $q->where('id', $id))
            ->when($name, fn ($q, $name) => $q->where('name', 'like', '%' . $name . '%'))
            ->get()
            ->toArray();

        return collect($products)
            ->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'price' => $v['price'],
                    'quality' => $v['quality']['name'] ?? null,
                    'car' => $v['car']['name'] ?? null,
                    'image' => $v['image']['path'] ?? null,
                    'piece_number' => $v['piece_number'] ?? null,
                ];
            });
    }

    public function store(Request $request): JsonResponse
    {
        $data = self::setValidation($request);
        $data['percentage_of_sale'] = intval($data['price']) * 0.05;

        $product = Product::query()->create($data);
        $data['image'] = $request->file('image')->store('products');

        $product->image()->create([
            'path' => $data['image'],
        ]);

        return response()->json(self::getProducts(id: $product->id));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $data = self::setValidation($request);
        $data['percentage_of_sale'] = intval($data['price']) * 0.05;

        $product->update($data);

        $oldImage = $product->image()?->first()?->path;

        if ($request->hasFile('image')) {
            if (File::exists($oldImage))
                File::delete($oldImage);

            $data['image'] = $request->file('image')->store('products');
            $product->image()->update([
                'path' => $data['image'],
            ]);
        }


        return response()->json(self::getProducts(id: $product->id), 200);
    }

    public function delete(Product $product): JsonResponse
    {
        $oldImage = $product->image()?->first()?->path;
        if (File::exists($oldImage))
            File::delete($oldImage);


        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully',
        ]);
    }

    public static function setValidation(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quality_id' => 'required|exists:qualities,id',
            'car_id' => 'required|exists:cars,id',
            'image' => $request->hasFile('image') ? 'required' : '',
            'image.*' => $request->hasFile('image') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
            'piece_number' => 'required',
        ]);
    }
}
