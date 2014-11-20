<?php namespace Product\Models;

use BaseModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Product extends BaseModel implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'products';

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to' => 'slug',
    );

    protected $fillable = array(
        'title',
        //'slug',
        'description',
        'category_id',
        'status',
        'url',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public function attribute()
    {
        return $this->hasMany('Product\Models\Attribute');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            foreach ($model->images as $image) {
                $image->delete();
            }
            foreach ($model->attribute as $attribute) {
                $attribute->delete();
            }
        });

    }
}