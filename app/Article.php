<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Markdown;

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

    /**
     * Get the comments for the article.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the votes for the article.
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * Get the vote of a user for the article.
     */
    public function voteValue($user_id)
    {
        $vote = Vote::where([
            ['article_id', $this->id],
            ['user_id', $user_id]
        ])->first();

        if ($vote) {
            return $vote->value;
        } else {
            return 0;
        }
    }

    /**
     * Get the issue for the article.
     */
    public function issue()
    {
        return $this->belongsToMany('App\Issue')->first();
    }

    public static function parseMarkdown($markdown)
    {
        return Markdown::parse($markdown);
    }

    public static function makeExcerpt($html)
    {
        return str_limit(
            strip_tags($html),
            140
        );
    }
}
