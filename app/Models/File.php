<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'type', 'path'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function getSize()
    {
        $filePath = $this->path;
        if (strpos($filePath, 'public/') === 0) {
            $filePath = substr($filePath, strlen('public/'));
        }

        $filePath = 'storage/' . $filePath;
        return number_format(filesize(public_path($filePath)) / (1024 * 1024), 2) . ' MB';
    }
}
