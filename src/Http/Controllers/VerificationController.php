<?php
namespace DJBDeveloper\LaravelAntiReplay\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController
{
    /**
     * 显示安全验证页面 (用于路由定义，但通常由中间件直接调用视图)。
     */
    public function show()
    {
        return view('anti-replay::verification');
    }

    /**
     * 处理来自前端的 AJAX 验证请求，设置 Session 标记。
     */
    public function verify(Request $request)
    {
        $request->session()->put('is_human_verified', true);
        return response()->noContent(); // 返回 204 No Content
    }
}