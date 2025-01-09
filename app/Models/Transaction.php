<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'account_id', 'categories_id', 'amount', 'type', 'description'
    ];

    public function categories(){
     return $this->belongsTo(Categories::class, 'categories_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
