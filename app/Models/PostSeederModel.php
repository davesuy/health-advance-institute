<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostSeederModel extends Model
{
    use HasFactory;
    // Define the table and other necessary properties
    protected $table = 'posts';

    protected $fillable = [
        'title', 'body', 'user_id',
    ];


}
