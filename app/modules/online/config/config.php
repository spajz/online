<?php

return array(

    'module' => array(
        'moduleTitle' => 'Online',
        'moduleUpper' => 'Online',
        'moduleLower' => 'online',
        'modelName' => 'Online\Models\Online',
        'moduleAdminRoute' => 'online',
    ),

    'subModules' => array(
        'category' => Config::get('online::category.module')
    ),

    'contentPath' => $path = app_path('modules/online/views/content'),

    'contentFiles' => array(
        'form' => '',
        'function'
    ),

    'image' => array(
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => true, // true or false
        'multiple' => true,
        'quality' => 85,
        'allowed_types' => 'jpeg,gif,png',
        'max' => '2000', // max size in kilobytes (0 for no limit)
        'sizes' => array(
            'original' => array(
                'quality' => 90,
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(800, null, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'medium' => array(
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(240, 240, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'thumb' => array(
                'folder' => 'thumb/',
                'actions' => array(
                    'resize' => array(80, 80, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
        ),
    ),
);