<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // table name
    protected $table = 'posts';
    // primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    // create relationship
    // what it says is: A post has a relationship with user and it
    // belong to a user
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
