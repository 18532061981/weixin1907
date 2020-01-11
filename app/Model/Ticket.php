<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    //
    protected $table = 'ticket';
    public $primaryKey = 'ticket_id';
    public $timestamps = false;
    protected $guarded=[];
}
