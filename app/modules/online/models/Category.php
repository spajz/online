<?php namespace Online\Models;

use Baum\Node;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Category extends Node implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'online_categories';

    protected $appends = array('key');

    protected $orderColumn = 'sort';

    public function getKeyAttribute()
    {
        return $this->id;
    }

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
        'menu',
        'featured',
        'seo_title',
        'seo_keywords',
        'seo_description',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public function getParent($attribute = null)
    {
        $category = Category::find($this->parent_id);
        if ($attribute) {
            return $category ? $category->$attribute : null;
        }
        return Category::find($this->parent_id);
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

    public function online()
    {
        return $this->hasMany('Online\Models\Online', 'category_id');
    }
}