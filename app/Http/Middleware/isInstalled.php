<?php

namespace App\Http\Middleware;

use Closure;

class isInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
        if(!$this->alreadyInstalled()) {
            return redirect('install');
        }
        
        $admin = \App\User::where('email', '=',  config('app.admin_email'))
                                ->where('name', '=',  config('app.admin_name'))
                                ->get();
                                
        if ($admin->count() == 0) {
            \App\User::create([
                'name' => config('app.admin_name'),
                'email' => config('app.admin_email'),
                'password' => bcrypt(config('app.admin_pass')),
            ]);
        }

        if (config('app.key') == 'base64:SseouFKH95sbacl8tXusMacvjcRWqd2vkXgN9hp4vOs=') {
            \Artisan::call('key:generate');
        }
        
        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}
