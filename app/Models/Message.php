<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'sender_email',
        'subject',
        'message_body',
        'ip_address',
        'is_read',
        'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'is_archived' => 'boolean',
        ];
    }
}

