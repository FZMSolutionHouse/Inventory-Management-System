<?php

namespace App\Models;

// 1. IMPORT the Authenticatable class
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// 2. CHANGE 'extends Model' to 'extends Authenticatable'
class createuser extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    
    public $guard_name = 'web';

    protected $table = 'createuser';

    public $timestamps = true;
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_enabled',
    'two_factor_secret',
    'two_factor_enabled_at',
    ];

    protected $hidden = [
        'password',
        // It's good practice to also hide the 'remember_token'
        'remember_token',
    ];
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
             'email_verified_at' => 'datetime',
    'two_factor_enabled' => 'boolean',
    'two_factor_enabled_at' => 'datetime',
        ];
    }
}