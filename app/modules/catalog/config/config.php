<?php

return array(

    'module' => array(
        'moduleUpper' => 'Catalog',
        'moduleLower' => 'catalog',
        'modelName' => 'Catalog\Models\Catalog',
    ),

    'region' => array(
        '1' => 'Region 01',
        '2' => 'Region 02',
        '3' => 'Region 03',
        '4' => 'Region 04',
        '5' => 'Region 05',
        '6' => 'Region 06',
        '7' => 'Region 07',
        '8' => 'Region 08',
    ),

    'type' => array(
        '1' => 'House',
        '2' => 'Apartment',
        '3' => 'Garage',
    ),

    'image' => array(
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => true, // true or false
        'multiple' => true,
        'quality' => 75,
        'allowed_types' => 'jpeg,gif,png',
        'max' => '500', // max size in kilobytes (0 for no limit)
        'sizes' => array(
            'original' => array(
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(800, 600, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'thumb' => array(
                'folder' => 'thumb/',
                'actions' => array(
                    'fit' => array(80, 60),
                ),
            ),
        ),
    ),

);