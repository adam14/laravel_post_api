<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'created_by', 'active', 'created_at', 'updated_at', 'updated_by', 'deleted_at'
    ];
}
