<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Line extends Model implements Sortable
{
    use HasFactory,SortableTrait;
    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];
    protected $guarded=[];
    protected $table='lines';

    public function region(){
        return $this->belongsTo(Region::class,'region_id');
    }
}
