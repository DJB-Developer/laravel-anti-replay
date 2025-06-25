<?php
namespace DJBDeveloper\LaravelAntiReplay\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AntiReplayMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 关键条件：只对根路径("/")的非AJAX GET请求进行处理
        if (!$request->is('/') || !$request->isMethod('GET') || $request->ajax()) {
            return $next($request);
        }

        // 检查会话中是否存在验证标记
        if ($request->session()->get('is_human_verified', false)) {
            // 如果已验证，则正常继续，加载Vue应用
            return $next($request);
        }

        // 如果未验证，直接返回验证视图，而不是重定向。
        // 这样做可以保留浏览器地址栏中的哈希值。
        return response()->view('anti-replay::verification');
    }
}