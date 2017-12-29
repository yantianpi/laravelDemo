<?php

namespace Peteryan;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * 模型关联表
     *
     * @var string
     */
    protected $table = 'project_list';

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
     * 本地作用域
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeActive(Builder $query) {
        return $query->where('Status', 'ACTIVE');
    }

    /**
     * one many one:project many:task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskList() {
        return $this->hasMany('Peteryan\Task', 'ProjectId', 'Id');
    }
}
