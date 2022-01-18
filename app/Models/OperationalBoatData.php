<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalBoatData extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tug(){
        return $this->belongsTo(Tug::class);
    }

    public function barge(){
        return $this->belongsTo(Barge::class);
    }
}
