<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    //
    protected $table = 'login';
    public $primaryKey = 'l_id';
    protected $fillable=['l_name','l_pwd'];

}
