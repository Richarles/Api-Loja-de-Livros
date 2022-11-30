<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = ['isbn','name','year','page','publisher_id'];

    public function publisher()
    {
        return $this->belongsTo(Publishers::class)
            ->withDefault([
                'identifier' => 'WITHOUT ID',
                'fname' => 'NOT FOUND',
                'lname' => 'NOT FOUND',
            ]);
    }

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'book_authors','book_id','author_id')
            ->using(BookAuthors::class)->withTimestamps();
    }
}

