<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sppg extends Model
{
    protected $fillable = ['name', 'location', 'lat', 'lng'];

    public function deliveries() { return $this->hasMany(Delivery::class); }
    public function financialRecords() { return $this->hasMany(FinancialRecord::class); }
}
