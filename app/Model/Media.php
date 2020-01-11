<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    //
    protected $table = 'media';
    public $primaryKey = 'me_id';
    public $timestamps = false;
    protected $guarded=[];

}
