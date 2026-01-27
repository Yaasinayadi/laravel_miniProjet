<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'service',
        'requested_role',
        'justification',
        'status',
        'admin_comment',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    // Relation avec l'admin qui a traité la demande
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
