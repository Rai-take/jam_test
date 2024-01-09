<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalSchedule extends Model
{
    use HasFactory;
    protected $table = 't_arrival_schedule';

    protected $fillable = [
        'arrival_status_id',
        'order_number',
        'arrival_schedule_date',
        'arrival_actual_date',
        'comment',
        'canceled_at',
        'canceled_by',
        'created_by',
        'updated_by',
        'is_active',
        'is_active_comment',
    ];
}
