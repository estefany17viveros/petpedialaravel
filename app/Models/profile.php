<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'phone',
        'address',
        'specialty',
        'experience_years',
        'qualifications',
        'clinic_name',
        'schedules',
        'responsible',
        'biography',
    ];

    protected $casts = [
        'schedules' => 'array', // para que Laravel lo maneje como array automáticamente
    ];

    /**
     * Relación: un perfil pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
