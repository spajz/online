<?php

return array(

    'module' => array(
        'moduleUpper' => 'Holiday',
        'moduleLower' => 'holiday',
        'modelName' => 'Holiday\Models\Holiday'
    ),

    'card_type' => array(
        'BanKomaT' => 'BanKomaT',
        'Prima' => 'Prima',
    ),

    'text_position' => array(
        'left' => 'Left',
        'right' => 'Right',
        'top' => 'Top',
        'bottom' => 'Bottom',
    ),

    'position_horizontal' => number_list(0, 100, null, 5),
    'position_vertical' => number_list(0, 100, null, 5),

    'font' => dir_list(public_path() . '/fonts'),

    'image' => array(
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => true, // true or false
        'multiple' => false,
        'quality' => 85,
        'allowed_types' => 'jpeg,gif,png',
        'max' => '2000', // max size in kilobytes (0 for no limit)
        'sizes' => array(
            'original' => array(
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(800, 800, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'thumb' => array(
                'folder' => 'thumb/',
                'actions' => array(
                    'resize' => array(100, 100, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
        ),
    ),
);