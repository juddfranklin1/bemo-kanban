<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Column;

class Card extends Model
{
    use HasFactory;

    public function column() {
        return $this->belongsTo(Column::class);
    }
}
