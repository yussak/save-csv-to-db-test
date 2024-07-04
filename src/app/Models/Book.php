<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "author_id",
        "title",
        "author",
        "company",
        "published_at",
        "increased_at",
        "earnings",
    ];
}
