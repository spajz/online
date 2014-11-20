<?php namespace Quiz\Models;

use BaseModel;

class Answer extends BaseModel
{
    protected $table = 'answers';

    protected $fillable = array(
        'question_id',
        'answer',
        'description',
        'type',
        'status',
        'sort',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public function question()
    {
        return $this->belongsTo('Quiz\Models\Question');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            foreach ($model->images as $image) {
                $image->delete();
            }
        });

    }
}