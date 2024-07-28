<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function applianceLists()
    {
        return $this->hasMany(ApplianceList::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
