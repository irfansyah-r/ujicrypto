<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'max_assets',
    ];
    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class);
    }
}
