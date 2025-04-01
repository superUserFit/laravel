<?php

namespace App\Domains\User\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->id = Str::uuid()->toString();
            $User = Auth::user();
            if(!empty($User)) {
                $model->created_by = $User->id;
            }
        });

        static::updating(function($model) {
            $User = Auth::user();
            if(!empty($User)) {
                $model->updated_by = $User->id;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setAccessToken($access_token)
    {
        // Hash the access token before saving it
        $hashed_token = Hash::make($access_token);

        $this->access_token = $hashed_token;
    }


    public function validateAccessToken($access_token)
    {
        return Hash::check($access_token, $this->access_token);
    }
}
