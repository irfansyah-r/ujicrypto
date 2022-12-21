<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['base', 'quote'];

    const UPDATED_AT = null;
    // public $timestamps = false;

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
