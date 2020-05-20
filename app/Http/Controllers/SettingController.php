<?php

namespace App\Http\Controllers;

/**
 * Class SettingController.
 */
class SettingController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(\Option::all());
    }

    /**
     * @param string $key
     *
     * @return mixed|void
     */
    public function show(string $key)
    {
        return \Option::get($key) ?? abort(404, \sprintf('设置项 %s 不存在', $key));
    }
}
