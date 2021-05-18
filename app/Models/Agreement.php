<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'meta_key',
        'term_length',
        'start_date_day',
        'start_date_month',
        'start_date_year',
        'start_date',
        'instalment_amount',

        'rental_amount_total',
        'profit_total',
        'profit_per_week',
        'profit_per_fortnight',
        'profit_per_month',
        'revenue_per_month',
        'finalised',
    ];
}
