<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class product extends Model
{
    use HasFactory,Notifiable;


    protected $table='products';


    public $timestamps = true;
 
    protected $fillable=[
        'name',
        'detail',
    ];
}
