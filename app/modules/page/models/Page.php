<?php namespace Page\Models;

use BaseModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Page extends BaseModel implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'pages';

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to' => 'slug',
    );

    protected $fillable = array(
        'title',
        //'slug',
        'description',
        'status',
        'sort',
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