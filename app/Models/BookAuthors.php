<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookAuthors extends Pivot
{
    use HasFactory;

    protected $table = 'book_authors';

    //protected $fillable = ['book_id', 'author_id'];
}
