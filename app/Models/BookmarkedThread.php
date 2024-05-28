<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkedThread extends Model
{
    use HasFactory;

    protected $table = 'bookmarked_threads';

    protected $guarded = ['id'];
}
