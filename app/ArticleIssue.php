<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleIssue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_issue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'issue_id'
    ];
}
