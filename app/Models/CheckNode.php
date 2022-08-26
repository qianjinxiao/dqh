<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class CheckNode extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='check_nodes';

    public function nodes(){
        return $this->belongsTo(Check::class,'check_id');
    }
    public function line(){
        return $this->belongsTo(Line::class,'line_id');
    }
    public function setImagesAttribute($value){
        $this->attributes['images']=json_encode($value);
    }
    public function setVideosAttribute($value){
        $this->attributes['videos']=json_encode($value);
    }
    public function getImagesAttribute($value){
        return json_decode($value,1);
    }
    public function getVideosAttribute($value){
        return json_decode($value,1);
    }
}
