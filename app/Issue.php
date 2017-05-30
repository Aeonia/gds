<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'published_at'
    ];

    /**
     * Get the articles for the issue.
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }
}
