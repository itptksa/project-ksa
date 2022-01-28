<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHead extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    // Protected $fillable = ['user_id'];
    Protected $hidden =['user_id','created_at','updated_at'];
}