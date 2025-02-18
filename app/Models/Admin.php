<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        "image"
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The hashed password.
     *
     * @var string<string, string>
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    #get initials to be displayed through the app
    public function getInitials()
    {
        $name = $this->name;
        $words = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
        $initials = '';

        if (count($words) === 1) {
            $firstChar = mb_substr($name, 0, 1);
            $secondChar = mb_substr($name, 1, 1);

            $initials .= $firstChar . $secondChar;
        } else {
            $firstWord = $words[0] ?? '';
            $lastWord = end($words) ?: '';

            $firstCharFirstWord = mb_substr($firstWord, 0, 1);
            $firstCharLastWord = mb_substr($lastWord, 0, 1);

            if (preg_match('/\p{Arabic}/u', $firstCharFirstWord)) {
                $initials .= $firstCharFirstWord . ' ';
            } else {
                $initials .= strtoupper($firstCharFirstWord);
            }

            if ($firstWord !== $lastWord) {
                if (preg_match('/\p{Arabic}/u', $firstCharLastWord)) {
                    $initials .= $firstCharLastWord . ' ';
                } else {
                    $initials .= strtoupper($firstCharLastWord);
                }
            }
        }

        return trim($initials);
    }


    #return the role for the admin
    public function getRole()
    {
        $has_roles = count($this->getRoleNames()) > 0 ? true : false;

        if ($has_roles) {
            $role = Role::where('name', $this->getRoleNames()[0])->first();

            if ($role) {
                if (app()->getLocale() == 'ar') {
                    return $role->name_ar;
                } else {
                    return $role->name;
                }
            }
        } else {
            return 'Default';
        }
        // return count($this->getRoleNames()) > 0 ? $this->getRoleNames()[0] : 'Default';
    }

    #check if the autherticated admin has the permission to do an action through roles and permissions
    public function hasAbilityTo($permission)
    {
        return $this->hasRole('Super Admin') || $this->can($permission) ? true : false;
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'admin_id');
    }

    public function ticketsFiltered($status = null)
    {
        if ($status == 'completed') {
            return $this->hasMany(Ticket::class, 'user_id')
                ->where('status', 'completed')
                ->whereNotNull('handeled_at')
                ->where('handeled', 1);
        } else {
            return $this->hasMany(Ticket::class, 'user_id')
                ->where('status', $status);
        }
    }
}
