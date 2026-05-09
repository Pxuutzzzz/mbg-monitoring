<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    protected $table = 'nutritions';
    protected $fillable = ['calories', 'protein_g', 'karbo_g', 'delivery_id'];

    public function delivery() { return $this->belongsTo(Delivery::class); }
}
