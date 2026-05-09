<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'sppg_id', 'target_group', 'serve_date', 'food_name', 
        'calories', 'protein_g', 'karbo_g', 'fat_g'
    ];

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
