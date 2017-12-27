<?php

namespace Peteryan\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 指定字符串默认最大长度，如果不指定，在数据库迁移时可能会因为key的长度过长导致失败
        Schema::defaultStringLength(191);

        // 监听sql执行
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
            $sql = $query->sql;
            $params = $query->bindings;
            if (env('DB_LOG', false) == true) {
                foreach ($params as $index => $param) {
                    if ($param instanceof \DateTime) {
                        $params[$index] = $param->format('Y-m-d H:i:s');
                    }
                }
                $sql = str_replace("?", "'%s'", $sql);
                array_unshift($params, $sql);
                Log::info('SQL输出------------>' . call_user_func_array('sprintf', $params));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
