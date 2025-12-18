<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'phone',
        'message'
    ];


    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope for read messages
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
