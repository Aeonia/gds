<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'article_id', 'user_id'
    ];

    /**
     * Get the article which has been voted.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
