<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'id_document_path', 'verification_status',
        'date_of_birth', 'rejection_reason', 'verified_at'
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('verification_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    // Helper methods
    public function getDocumentUrlAttribute()
    {
        return asset('storage/' . $this->id_document_path);
    }

    public function approve()
    {
        $this->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'rejection_reason' => null
        ]);

        // Update user verification status
        $this->user->update(['is_verified' => true]);
    }

    public function reject($reason)
    {
        $this->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $reason,
            'verified_at' => null
        ]);

        // Update user verification status
        $this->user->update(['is_verified' => false]);
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isApproved()
    {
        return $this->verification_status === 'approved';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }
}