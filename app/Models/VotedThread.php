<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotedThread extends Model
{
    use HasFactory;

    protected $table = 'voted_threads';

    protected $guarded = ['id'];
}
