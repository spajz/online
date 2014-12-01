<?php namespace Online\Models;

use BaseModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Conner\Tagging\TaggableTrait;

class Online extends BaseModel implements SluggableInterface
{
    use TaggableTrait;
    use SluggableTrait;

    protected $table = 'online';

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
        'category_id'
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

    public function getTags($return = 'string')
    {
        $tags = $this->tagged();
        if (count($tags)) {
            $list = $tags->lists('tag_name');
            if ($return == 'string') return implode(',', $list);
            return $list;

        }
        return null;
    }

    public function category()
    {
        return $this->belongsTo('Online\Models\Category', 'category_id');
    }
}