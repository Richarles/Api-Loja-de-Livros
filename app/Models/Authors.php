<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\Author;

class Authors extends Model
{
    use HasFactory;

    protected $fillable = ['identifier','fname','lname'];

    public function books(){
        return $this->belongsToMany(Books::class,'book_authors','book_id','author_id')->using(BookAuthors::class);
    }
}
