<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users(){
        // リレーションの定義
        return $this->belongsToMany('App\Models\Users\Subject', 'subject_users', 'user_id', 'subject_id');
    }
}
