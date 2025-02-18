<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "username",
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

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function ticketsWithTrashed()
    {
        return $this->hasMany(Ticket::class, 'user_id')->withTrashed();
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


    public function getTotalMaintenanceHours()
    {
        return $this->projects()->sum('hours');
    }
}
