<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\SubjectsController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function getSubject(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('teacher'))
            $query = Product::with([
                'level:id,name',
                'teacher:id,name,email',
                'section:id,name',
            ])->whereRelation('teacher', 'id', '=', $user->id);
        else
            $query = Product::with([
                'level' => fn ($q) => $q->with('student:id,name'),
                'teacher:id,name,email',
                'section:id,name',
            ])->where('section_id', '=', $user->section_id)
                ->whereHas('level', fn ($q) => $q->whereRelation('student', 'id', '=', $user->id));

        $subject = collect($query->get()->toArray())
            ->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'file' => $v['file'],
                    'level' => $v['level']['name'] ?? null,
                    'teacher' => $v['teacher']['name'] ?? null,
                    'section' => $v['section']['name'] ?? null
                ];
            });
        return response()->json($subject->toArray());
    }

    public function setSubjectFile(Request $request)
    {
        Product::query()->updateOrCreate(['id' => $request->id], [
            'file' => $request->file('file')->store('Files/Subjects')
        ]);
        return response()->json('تم رفع الملف بنجاح');
    }

    public function getStudentByLevel()
    {
    }
}
