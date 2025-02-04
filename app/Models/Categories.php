<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class categories extends Model
{
    //
    protected $fillable = [
        'name', 'type'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class, 'categories_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
