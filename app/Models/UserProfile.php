<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    
    protected $table = 'userprofile';
    
    protected $fillable = [
        'user_id',
        'name',
        'phonenumber',
        'email',
        'role',
        'image'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(createuser::class, 'user_id');
    }
    
    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://i.pravatar.cc/40';
    }
}