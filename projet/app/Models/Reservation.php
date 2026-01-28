<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'resource_id', 'start_date', 'end_date', 'status', 'reason'
    ];

    //reservation appartient a un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //reservation concerne une ressource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
