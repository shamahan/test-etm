<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'UserID';
    
    protected $fillable = [
        'UserName'
    ];

    public function companies() 
    {
        return $this->belongsToMany(Company::class);
    }
}
