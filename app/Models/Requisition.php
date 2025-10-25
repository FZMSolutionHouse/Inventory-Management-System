<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Requisition extends Model
{
    use HasFactory;

    protected $table = 'requisition';

    protected $fillable = [
        'name',
        'designation',
        'subject',
        'file_path',
        'content',
        'description',
        'status',
        'page1_completed',
        'page2_completed',
        'fully_completed',
        'email',
        'user_ip',
    ];

    protected $casts = [
        'page1_completed' => 'boolean',
        'page2_completed' => 'boolean',
        'fully_completed' => 'boolean',
    ];

    // Helper methods
    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function isComplete()
    {
        return $this->fully_completed;
    }

    public function getStatusBadgeAttribute()
    {
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $statusColors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getCompletionStatusAttribute()
    {
        if ($this->fully_completed) {
            return 'Complete';
        } elseif ($this->page1_completed) {
            return 'Page 1 Complete - Awaiting Page 2';
        } else {
            return 'Not Started';
        }
    }
}