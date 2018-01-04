<?php

namespace Peteryan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * 模型关联表
     *
     * @var string
     */
    protected $table = 'task_list';

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

    /**
     * 不可以被批量赋值的属性
     *
     * @var array
     */
    public $guarded = [];

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
     * many one one:category many:task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('Peteryan\Category', 'CategoryId', 'Id');
    }

    /**
     * many one one:project many:task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project() {
        return $this->belongsTo('Peteryan\Project', 'ProjectId', 'Id');
    }
}
