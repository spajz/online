<?php namespace Slider\Models;

use BaseModel;

class Slider extends BaseModel
{
    protected $table = 'sliders';

    protected $fillable = array(
        'title',
        'url',
        'description',
        'sort',
        'status',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
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