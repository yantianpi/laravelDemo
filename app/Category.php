<?php

namespace Peteryan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Peteryan\Scopes\CategoryScope;

class Category extends Model
{
    /**
     * 模型关联表
     *
     * @var string
     */
    protected $table = 'category_list';

    /**
     * 模型关联表主键
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * 不希望eloquent自动维护添加时间以及更新时间(created_at,updated_at)
     *
     * @var bool
     */
    public $timestamps = false;

    protected static function boot() {
        parent::boot();
        /*
         * 应用全局作用域
         */
//        static::addGlobalScope(new CategoryScope());
    }

    /**
     * 本地作用域
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeActive(Builder $query) {
        return $query->where('Status', 'ACTIVE');
    }

    /**
     * one many one:category many:attribute
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeList() {
        return $this->hasMany('Peteryan\Attribute', 'CategoryId', 'Id');
    }
}
