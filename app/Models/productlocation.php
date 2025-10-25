<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class productlocation extends Model
{
    use HasFactory , Notifiable;
    
    protected $table='productlocation';

    public $timestamps = true;

     protected $fillable=[
        'name',
        'product_name',
        'description',
        'latitude',	
        'longitude'
    ];
}
