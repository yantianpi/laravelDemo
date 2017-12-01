<?php
/**
 * Created by PhpStorm.
 * User: peteryan
 * Date: 2017/12/1
 * Time: 16:44
 */


namespace Peteryan\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CategoryScope implements Scope {
    /**
     * 应用作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('Status', 'ACTIVE');
    }
}