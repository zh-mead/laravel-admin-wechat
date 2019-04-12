<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZhMead\WeChat\Middleware;

use Closure;
use ZhMead\WeChat\Events\WebAuthenticate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use http\Env\Request;

/**
 * Class OAuthAuthenticate.
 */
class WeChatAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopes
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $account = 'default', $scopes = 'snsapi_userinfo')
    {
        // $account 与 $scopes 写反的情况
        if (is_array($scopes) || (\is_string($account) && str_is('snsapi_*', $account))) {
            list($account, $scopes) = [$scopes, $account];
            $account || $account = 'default';
        }

        if (!env('WECHAT_DEBUG', true)) {
            Auth::guard('wechat')->loginUsingId(1);
        }

        if (Auth::guard('wechat')->check()) return $next($request);
        $sessionKey = \sprintf('wechat.oauth_user.%s', $account);
        $config = config(\sprintf('wechat.official_account.%s', $account), []);
        $officialAccount = app(\sprintf('wechat.official_account.%s', $account));
        $scopes = $scopes ?: array_get($config, 'oauth.scopes', ['snsapi_base']);

        if (is_string($scopes)) {
            $scopes = array_map('trim', explode(',', $scopes));
        }
        $session = session($sessionKey, []);

        if (!$session) {
            if ($request->has('code')) {
                session([$sessionKey => $officialAccount->oauth->user() ?? []]);
                Event::fire(new WebAuthenticate(session($sessionKey)));
                return redirect()->to($this->getTargetUrl($request));
            }

            session()->forget($sessionKey);

            return $officialAccount->oauth->scopes($scopes)->redirect($request->fullUrl());
        }

        Event::fire(new WebAuthenticate(session($sessionKey)));

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }
}
