<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\AnalysisType;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * This for get status from table status
     * @param $status
     * @return Model|Builder|null
     */
    public static function status($status): Model|Builder|null
    {
        return Status::query()->where('status', '=', strtoupper($status))->first();
    }

    public static function getADDData($class, $date = null, $id = null, $userId = null)
    {
        return $class->when($date, fn($query, $date) => $query->whereDate('date', '=', $date))
            ->when($id, fn($query, $id) => $query->where('id', $id))
            ->when($userId, fn($query, $userId) => $query->whereRelation('patient', 'id', '=', $userId))
            ->get(['id', 'date', 'type', 'patient', 'status'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'type' => $item->type()->first()?->name,
                    'patient' => $item->patient()->first()?->name,
                    'status' => $item->status()->first()?->status,
                    'reason' => $item->reason()->first()?->reason,
                ];
            });
    }
}
