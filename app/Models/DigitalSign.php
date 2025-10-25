<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalSign extends Model
{
    use HasFactory;

    protected $table = 'digital_sign'; // Specify the table name

    protected $fillable = [
        'name',
        'email',
        'Related_item', // Match the database field name
        'description',
        'signature',
    ];

    /**
     * Relationship with signatures (using the signature package)
     */
    public function signature()
    {
        return $this->morphOne(\Creagia\LaravelSignPad\Signature::class, 'model');
    }
}