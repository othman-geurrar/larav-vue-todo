<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'address',

    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
    ];

 

    /**
     * Méthodes requises pour JWT - IMPORTANT !
     */
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
        ];
    }

    /**
     * Relation avec les tâches
     */
        public function tasks()
        {
            return $this->hasMany(Task::class);
        }


    /**
     * Obtenir les initiales du nom complet
     */
    // public function getInitialsAttribute(): string
    // {
    //     $names = explode(' ', $this->full_name);
    //     $initials = '';
        
    //     foreach ($names as $name) {
    //         $initials .= substr($name, 0, 1);
    //     }
        
    //     return strtoupper(substr($initials, 0, 2));
    // }

    /**
     * Formater le numéro de téléphone
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->phone_number) {
            return null;
        }
        
        // Exemple de formatage simple
        return $this->phone_number;
    }
}