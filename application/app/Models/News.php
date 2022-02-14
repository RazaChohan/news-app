<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'news';

    /**
     * @inheritdoc
     */
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * Get the user that owns the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->content = $model->content . ' ' . 'Model trigger';
            $model->save();
        });
    }
}
