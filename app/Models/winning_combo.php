<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winning_combo extends Model
{
    protected  $table = 'winning';
    protected $fillable = [
        'winning_combos', 'combo'
    ];
    use HasFactory;
}
