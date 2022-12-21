<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indication extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id', 'ma_trend', 'ma_crossover',
        'psar_trend', 'psar_reversal', 'stochastic_trend',
        'stochastic_crossover'
    ];
    const CREATED_AT = null;

    public static function trend($attribute)
    {
        return  Self::select($attribute)->distinct($attribute)->get();
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
