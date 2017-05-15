<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'html_content', 'excerpt', 'user_id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user that wrote the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
