<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'driver_id',
        'name',
        'email',
        'password',
        'phone',
        'license_number',
        'vehicle_type',
        'vehicle_plate',
        'address',
        'date_of_birth',
        'role',
        'status',
        'availability',
        'rating',
        'completed_deliveries',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'rating' => 'decimal:1',
        ];
    }

    // Filament access control
    public function canAccessPanel(Panel $panel): bool
    {
        // Admin panel hanya untuk role admin
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }
        
        // Hamid panel (default) untuk semua user yang authenticated
        return true;
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    // Generate unique driver ID
    public static function generateDriverId(): string
    {
        do {
            $id = 'DRV-' . strtoupper(substr(uniqid(), -10));
        } while (self::where('driver_id', $id)->exists());

        return $id;
    }

    // Accessor for status badge color
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'gray',
            'suspended' => 'danger',
            default => 'gray',
        };
    }

    // Accessor for availability badge color
    public function getAvailabilityColorAttribute(): string
    {
        return match($this->availability) {
            'available' => 'success',
            'on_duty' => 'warning',
            'on_leave' => 'gray',
            default => 'gray',
        };
    }

    // Get driver initials for avatar
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        if (count($names) >= 2) {
            return strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    // Get completion rate
    public function getCompletionRateAttribute(): int
    {
        // For now, return a default value
        // Later can be calculated from actual shipments
        return $this->completed_deliveries > 0 ? 95 : 0;
    }
}