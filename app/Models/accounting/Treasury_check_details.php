<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury_check_details extends Model
{
    use HasFactory;
    public $table = 'treasury_check_details';

    public $fillable = [
        'treasury_id',
        'treasury_journal',
        'date_collect_check',
        'number_check',
        'credit',
        'note',
        'creator_id',
        'updated_by',
    ];
}
