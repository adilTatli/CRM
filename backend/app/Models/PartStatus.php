<?php

namespace App\Models;

use App\Enums\PartStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public static function allStatuses()
    {
        return array_map(fn($status) => $status->value, PartStatusEnum::cases());
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
