<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
             'is_admin' => 'boolean', // Asegúrate de que tu modelo User tenga un atributo $casts para que is_admin se interprete como un booleano:
        ];
    }

    public function adminlte_image(){
         return 'https://picsum.photos/300/300';

    }

    public function adminlte_desc()
    {

            
           // Verifica si tiene el rol de 'Administrador'
        if ($this->hasRole('Administrador')) {
            return 'Administrador';
        }

        // Si no es Administrador, obtén el nombre de su primer rol (o el que quieras mostrar)
        // getRoleNames() devuelve una colección de nombres de roles.
        // first() tomará el primer rol de esa colección.
        $roleName = $this->getRoleNames()->first();

        // Si tiene algún rol, devuelve ese nombre. De lo contrario, puedes devolver un valor por defecto.
        return $roleName ? $roleName : 'Sin Rol Asignado';

        
    }
    
    public function adminlte_profile_url()
    {
        return '/profile';
    }

       public function isAdmin()
    {
        
        return $this->hasRole('Administrador'); // Utiliza el método hasRole() proporcionado por Spatie
    }

    



}
