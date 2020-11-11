<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     *
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

    /**
     * @param string $key
     */
    public function show(string $key)
    {
        return \Option::get($key) ?? abort(404, \sprintf('设置项 %s 不存在', $key));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $key
     *
     * @return mixed
     */
    public function update(Request $request, string $key)
    {
        \Option::set($key, $request->all());

        return \Option::get($key);
    }

    /**
     * @param string $key
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $key)
    {
        \Option::remove($key);

        return response()->noContent();
    }
}
