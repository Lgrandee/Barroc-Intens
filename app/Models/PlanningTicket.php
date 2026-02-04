<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningTicket extends Model
{
    use HasFactory;

    protected $table = 'planning_tickets';

    protected $fillable = [
        'catagory',
        'feedback_id',
        'location',
        'scheduled_time',
        'appointment_date',
        'user_id',
        'status',
        'priority',
        'used_materials',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
