<?php

// app/Models/Export.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Export extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFilePathAttribute($value)
    {
        return Storage::disk('local')->url($value);
    }
}
