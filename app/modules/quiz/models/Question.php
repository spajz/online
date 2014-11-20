<?php namespace Quiz\Models;

use BaseModel;

class Question extends BaseModel
{
    protected $table = 'questions';

    protected $fillable = array(
        'question',
        'description',
        'status',
        'sort',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public function answers()
    {
        return $this->hasMany('Quiz\Models\Answer');
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