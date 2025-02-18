<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        "user_id",
        "project_id",
        "priority",
        "description",
        "status",
        "admin_id",
        "estimated_hours",
        "handeled",
        "ticket_id",
        "handeled_at"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function projectWithTrashed()
    {
        return $this->belongsTo(Project::class, 'project_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
    public function userWithTrashed()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function files()
    {
        return $this->hasMany(File::class, 'ticket_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'ticket_id');
    }
}
