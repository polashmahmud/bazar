<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pin_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin_code_set_at' => 'datetime',
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Check if user has set a pin code
     */
    public function hasPinCode(): bool
    {
        return !is_null($this->pin_code);
    }

    /**
     * Set pin code for the user
     */
    public function setPinCode(string $pinCode): bool
    {
        $this->pin_code = $pinCode;
        $this->pin_code_set_at = now();
        return $this->save();
    }

    /**
     * Verify pin code
     */
    public function verifyPinCode(string $pinCode): bool
    {
        return $this->pin_code === $pinCode;
    }

    /**
     * Remove pin code
     */
    public function removePinCode(): bool
    {
        $this->pin_code = null;
        $this->pin_code_set_at = null;
        return $this->save();
    }
}
