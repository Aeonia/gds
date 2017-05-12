<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

    /**
     * Get the user that wrote the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
