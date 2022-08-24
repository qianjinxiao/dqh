<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class UserImei extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'user_imei';
    public $guarded=[];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public static function getDefault($user){
        return UserImei::query()->where(['user_id'=>$user->id,'default'=>1])->first();
    }
}
