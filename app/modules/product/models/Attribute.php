<?php namespace Product\Models;

use BaseModel;
use ImageApi;

class Attribute extends BaseModel
{
    protected $table = 'attributes';

    protected $appends = array('hexColor');

    protected $fillable = array(
        'product_id',
        'type',
        'value',
        'status',
        'sort',
    );

    public function images()
    {
        return $this->morphMany('ImageModel', 'model');
    }

    public function product()
    {
        return $this->belongsTo('Product\Models\Product');
    }

    public function setValueAttribute($value)
    {
        if ($this->attributes['type'] = 'color') {
            $this->attributes['value'] = hexdec($value);
        }
    }

    public function getValueAttribute($value)
    {
        return ucfirst($value);
    }

    public function getHexColorAttribute()
    {
        return '#' . dechex($this->attributes['value']);
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
