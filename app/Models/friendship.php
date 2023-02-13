<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friendship extends Model
{
    use HasFactory;

    protected $fillable = ['requester_id','user_requested','status'];

  
}
