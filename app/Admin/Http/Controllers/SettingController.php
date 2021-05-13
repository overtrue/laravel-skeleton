<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(\Option::all());
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|string',
            'value' => 'required',
        ]);

        \Option::set($request->get('key'), $request->get('value'));

        return \Option::get($request->get('key'));
    }

    public function show(string $key)
    {
        return \Option::get($key) ?? abort(404, \sprintf('设置项 %s 不存在', $key));
    }

    public function update(Request $request, string $key)
    {
        \Option::set($key, $request->all());

        return \Option::get($key);
    }

    public function destroy(string $key): \Illuminate\Http\Response
    {
        \Option::remove($key);

        return response()->noContent();
    }
}
