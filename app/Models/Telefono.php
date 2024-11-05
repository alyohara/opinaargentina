<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Telefono extends Model
{
    use HasFactory;

    protected $fillable = ['telefono', 'movil', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
