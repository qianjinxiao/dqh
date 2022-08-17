<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'problem';
    public function setImagesAttribute($value){
        $this->attributes['images']=json_encode($value,1);
    }
    public function getImagesAttribute($value){
        return json_decode($value,1);
    }
}
