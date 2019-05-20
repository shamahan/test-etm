<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'CompanyID';

    protected $fillable = [
        'CompanyName'
    ];

    public function users() 
    {
        return $this->belongsToMany(User::class);
    }
}
