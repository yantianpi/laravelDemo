<?php

namespace Peteryan;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * 模型关联表
     *
     * @var string
     */
    protected $table = 'attribute_list';

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
     * many one one:category many:attribute
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('Peteryan\Category', 'CategoryId', 'Id');
    }

}
