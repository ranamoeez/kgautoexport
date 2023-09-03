<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Level;
use App\Models\AdminLevel;
use App\Models\OperatorLevel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'AppPassword', 'main_user_id', 'level_id', 'admin_level_id', 'operator_level_id', 'balance', 'role', 'surname', 'phone', 'address', 'company', 'fax', 'country', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'AppPassword', 'role', 'api_token', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_level(){
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function admin_level(){
        return $this->belongsTo(AdminLevel::class, 'admin_level_id');
    }

    public function operator_level(){
        return $this->belongsTo(OperatorLevel::class, 'operator_level_id');
    }
}
