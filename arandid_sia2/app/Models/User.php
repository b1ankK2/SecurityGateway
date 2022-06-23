<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'tbluser';
 
    protected $fillable = [
        'user', 'password', 'jobid'
    ];

    public $timestamps = false;
    protected $primaryKey = 'userid';
}