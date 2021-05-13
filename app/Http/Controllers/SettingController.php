<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(\Option::all());
    }

    public function show(string $key)
    {
        return \Option::get($key) ?? abort(404, \sprintf('设置项 %s 不存在', $key));
    }
}
