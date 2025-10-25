<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsNotification extends Model
{
    use HasFactory;

    protected $table = 's_m_s_notification';

    protected $fillable = [
        'user_id',
        'phone_number',
        'message',
        'notification_type',
        'status',
        'error_message',
        'provider_message_id',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }

    public function markAsSent($messageId = null)
    {
        $this->update([
            'status' => 'sent',
            'provider_message_id' => $messageId,
            'sent_at' => now(),
            'error_message' => null
        ]);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage
        ]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}