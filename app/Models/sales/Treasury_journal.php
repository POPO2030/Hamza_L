<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury_journal extends Model
{
    use HasFactory;
    public $table = 'treasury_journals';

    public $fillable = [
        'balance_first_duration',
        'note',
        'date',
        'treasury_id',
    ];
}
