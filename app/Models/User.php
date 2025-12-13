<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */ 
    protected $connection = 'mysql';
    
    protected $table = 'users';
    protected $fillable = [
        // 'name', 'email', 'password', 'authentik_id', 'authentik_token'
        
            'StaffID',
            'EmployeeNo',  
            'name',                     
            'ImageUrl', 
            'email',
            'NationalIDNo', 
            'BusinessUnitName', 
            'BusinessUnitPath', 
            'Designation', 
            'AppointmentMode', 
            'JoinDateOffice', 
            'department',            
            'email_verified_at',
            'password',
            'authentik_id',
            'authentik_token',              
            'authentik_refresh_token',
            'authentik_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
         
        'remember_token',
        // 'password',
        // 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

//     public function roles()
// {
//     return $this->belongsToMany(Role::class);
// }

// public function hasRole($role)
// {
//     return $this->roles()->where('name', $role)->exists();
// }

// public function hasPermission($permission)
// {
//     return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
//         $query->where('name', $permission);
//     })->exists();
// }
   
}