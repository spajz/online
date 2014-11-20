<?php namespace Catalog\Models;

use BaseModel;
use ImageApi;

class Catalog extends BaseModel
{
    protected $table = 'catalog';

    protected $fillable = array(
        'title',
        'image',
        'price',
        'area',
        'region',
        'type',
        'status',
        'hash',
        'description',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model)
        {
            $model->images()->delete();
        });

    }
}
