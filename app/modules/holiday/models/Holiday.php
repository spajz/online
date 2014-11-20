<?php namespace Holiday\Models;

use BaseModel;
use ImageApi;

class Holiday extends BaseModel
{
    protected $table = 'holiday';

    protected $fillable = array(
        'description',
        'full_name',
        'email',
        'phone',
        'place_of_payment',
        'card_type',
        'photo',

        'text_position',
        'text_color',
        'text_size',
        'bg_color',
        'bg_transparency',
        'angle',
        'font',
        'greyscale',

        'stage',
        'status',
        'hash_delete',
        'hash_activate',
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
