<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->withTrashed();
    }
}
