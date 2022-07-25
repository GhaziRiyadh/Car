<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Content\ClassesRequest;
use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\Classes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class BillController extends Controller
{
    public static function getBills($status = null, $id = null, $name = null): \Illuminate\Support\Collection
    {
        $bills = Bill::with([
            'status',
            'seller',
            'payer',
            'products',
        ])
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->when($name, fn ($q, $r) => $q->whereRelation('seller', 'name', 'like', '%' . $r . '%'))
            ->when($status, fn ($q, $r) => $q->where('status_id', '=', $r))
            ->get()
            ->toArray();

        return collect($bills)
            ->map(fn ($v) => [
                'id' => $v['id'],
                'seller' => $v['seller']['name'],
                'date' => $v['date'],
                'payer' => $v['payer']['name'],
                'total' => $v['total'],
                'status' => $v['status']['name'],
                'products' => $v['products'],
                'status_id' => $v['status_id'],
            ]);
    }

    public function changeStatus(Bill $bill, $status): JsonResponse
    {
        $status = BillStatus::where('name', '=', $status)->first();
        $bill->update(['status_id' => $status->id]);
        // if ($status == 'قيد التوصيل') {
        //     $confirm_code = rand(100000, 999999);
        //     $bill->update(['confirm_code' => $confirm_code]);
        //     $basic  = new Basic("3d0d771e", "sqEqpBWCOXNw2aJA");
        //     $client = new Client($basic);
        //     $response = $client->sms()->send(new SMS("967733649039", 'Car', 'رمز التأكد:' . $confirm_code));
        // }
        return response()->json(self::getBills(id: $bill->id));
    }

    public function statusCount(): JsonResponse
    {
        $count = BillStatus::all()->mapWithKeys(fn ($v) => [$v->name => $v->bills->count()]);

        return response()->json($count);
    }
}
