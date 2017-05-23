<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'article_id', 'content'
    ];

    /**
     * Get the article for which the notification was fired.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
