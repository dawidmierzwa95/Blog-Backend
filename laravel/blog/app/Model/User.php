<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array'
    ];

    /**
     * Create new api token for user
     *
     * @return string
     */
    public function createApiToken()
    {
        $this->api_token = Str::random(40);
        $this->save();

        return $this->api_token;
    }

    /**
     * Create new password for user
     *
     * @return string
     */
    public function createNewPassword()
    {
        $pass = Str::random(40);

        $this->password = bcrypt($pass);
        $this->save();

        return $pass;
    }

    /**
     * Check if user has specific permissions
     * e.g. "ADMIN" or "ADMIN|COPYWRITER" as multiple
     *
     * @param string $permission
     * @return string
     */
    public function hasPermission(string $permission) {
        return (count(array_intersect($this->permissions, explode("|", $permission))));
    }
}
