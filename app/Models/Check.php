<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Check extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='checks';

    public function nodes(){
        return $this->hasMany(CheckNode::class,'check_id');
    }
}
