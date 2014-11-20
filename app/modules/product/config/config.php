<?php

return array(

    'module' => array(
        'moduleUpper' => 'Product',
        'moduleLower' => 'product',
        'modelName' => 'Product\Models\Product',
    ),

    'attributes' => array(
        'color' => 'Color'
    ),

    'color_distance' => 100,

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
                    'resize' => array(500, 500, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'medium' => array(
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(160, 160, function ($image) {
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


    'categories' => array(
        '1' => 'Living Room',
        '2' => 'Garden',
        '3' => 'Bedroom',
        '4' => 'Bathroom',
        '5' => 'Kitchens',
        '6' => 'Lighting',
        '7' => 'Childrens IKEA',
        '8' => 'Textiles & Rugs',
        '9' => 'Home Office',
    ),

    'sub_categories' => array(
        '1' => array(
            '10' => 'Sofas & Armchairs',
            '11' => 'TV Stands & Cabinets',
            '12' => 'Living Room Storage',
            '13' => 'Coffee & Side Tables',
            '14' => 'Living Room Lighting',
            '15' => 'Living Room Textiles & Rugs',
        ),
        '2' => array(
            '16' => 'Garden Tables & Chairs',
            '17' => 'Garden Relaxing Furniture',
            '18' => 'Garden Storage & Covers',
            '19' => 'Outdoor Cushions',
            '20' => 'Decorative & Solar Lights',
            '21' => 'Parasols & Gazebos',
            '22' => 'Garden Plants & Pots',
            '23' => 'Garden Decking',
            '24' => 'Barbecues',
        ),
        '3' => array(
            '25' => 'Mattresses',
            '26' => 'Beds',
            '27' => 'Wardrobes & Bedroom Storage',
            '28' => 'Bedroom Lighting',
            '29' => 'Bedding, Textiles & Rugs',
            '30' => 'Mirrors',
        ),
        '4' => array(
            '31' => 'Bathroom Sink Cabinets',
            '32' => 'Bathroom Cabinets & Storage',
            '33' => 'Bathroom Sinks',
            '34' => 'Bathroom Taps',
            '35' => 'Bathroom Mirrors',
            '36' => 'Bath & Shower Textiles',
            '37' => 'Bath, Shower & Toilet Accessories',
            '38' => 'Bathroom lighting',
        ),
        '5' => array(
            '39' => 'Kitchen Cabinets & Doors',
            '40' => 'Kitchen Cabinet Interiors',
            '41' => 'Kitchen Appliances',
            '42' => 'Freestanding Kitchens',
            '43' => 'Modular Kitchens',
            '44' => 'Kitchen Worktops',
            '45' => 'Kitchen Taps & Sinks',
            '46' => 'Wall Storage',
            '47' => 'Kitchen Wall Panels',
            '48' => 'Kitchen Islands & Trolleys',
            '49' => 'Step stools & step ladders',
            '50' => 'Kitchen Integrated Lighting',
            '51' => 'Pantry',
            '52' => 'Knobs & handles',
        ),
        '6' => array(
            '77' => 'LED Lights',
            '78' => 'Table lamps',
            '79' => 'Ceiling Lights',
            '80' => 'Lamp Shades',
            '81' => 'Bases & Cords',
            '82' => 'Work lamps',
            '83' => 'Floor lamps',
            '84' => 'Integrated Lighting',
            '85' => 'Spotlights',
            '86' => 'Wall Lights',
            '87' => 'Childrens lighting',
            '88' => 'Light Bulbs & Accessories',
            '89' => 'Decorative & Solar Lights',
            '90' => 'Outdoor lighting',
            '91' => 'Bathroom lighting ',
            '92' => 'Childrens lighting 8-12',
        ),
        '7' => array(
            '53' => 'Baby',
            '54' => 'Children (Age 3-7)',
            '55' => 'Children (Age 8-12)',
        ),
        '8' => array(
            '56' => 'Rugs',
            '57' => 'Bedding',
            '58' => 'Curtains & Blinds',
            '59' => 'Curtain Rails & Rods',
            '60' => 'Fabrics & Sewing',
            '61 ' => 'Cushions & Cushion Covers ',
            '62' => 'Blankets & throws',
            '63' => 'Kitchen Textiles',
            '64' => 'Place Mats & Dining Textiles',
            '65' => 'Bathroom textiles',
            '66' => 'Childrens Bedding & Textiles',
            '67' => 'Baby Textiles',
            '68' => 'Mattress & pillow protectors',
        ),
        '9' => array(
            '69' => 'Desks & Tables',
            '70' => 'Office Chairs',
            '71' => 'Workspace Storage',
            '72' => 'Bins & Bags',
            '73' => 'Paper & Media Organisers',
            '74' => 'Lighting',
            '75' => 'Cable management & accessories',
            '76' => 'Laminate Flooring',
        ),
    ),

    'categories_text' => array(
        'living_room' => 'Living Room',
        'garden' => 'Garden',
        'bedroom' => 'Bedroom',
        'bathroom' => 'Bathroom',
        'kitchens' => 'Kitchens',
        'lighting' => 'Lighting',
        'childrens_ikea' => 'Childrens IKEA',
        'textiles_and_rugs' => 'Textiles & Rugs',
        'home_office' => 'Home Office',
    ),

    'sub_categories_text' => array(
        'living_room' => array(
            'sofas_and_armchairs' => 'Sofas & Armchairs',
            'tv_stands_and_cabinets' => 'TV Stands & Cabinets',
            'living_room_storage' => 'Living Room Storage',
            'coffee_and_side_tables' => 'Coffee & Side Tables',
            'living_room_lighting' => 'Living Room Lighting',
            'living_room_textiles_and_rugs' => 'Living Room Textiles & Rugs',
        ),
        'garden' => array(
            'garden_tables_and_chairs' => 'Garden Tables & Chairs',
            'garden_relaxing_furniture' => 'Garden Relaxing Furniture',
            'garden_storage_and_covers' => 'Garden Storage & Covers',
            'outdoor_cushions' => 'Outdoor Cushions',
            'decorative_solar_lights' => 'Decorative & Solar Lights',
            'parasols_and_gazebos' => 'Parasols & Gazebos',
            'garden_plants_and_pots' => 'Garden Plants & Pots',
            'garden_decking' => 'Garden Decking',
            'barbecues' => 'Barbecues',
        ),
        'bedroom' => array(
            'mattresses' => 'Mattresses',
            'beds' => 'Beds',
            'wardrobes_and_bedroom_storage' => 'Wardrobes & Bedroom Storage',
            'bedroom_lighting' => 'Bedroom Lighting',
            'bedding_textiles_and_rugs' => 'Bedding, Textiles & Rugs',
            'mirrors' => 'Mirrors',
        ),
        'bathroom' => array(
            'bathroom_sink_cabinets' => 'Bathroom Sink Cabinets',
            'bathroom_cabinets_and_storage' => 'Bathroom Cabinets & Storage',
            'bathroom_sinks' => 'Bathroom Sinks',
            'bathroom_taps' => 'Bathroom Taps',
            'bathroom_mirrors' => 'Bathroom Mirrors',
            'bath_and_shower_textiles' => 'Bath & Shower Textiles',
            'bath_shower_and_toilet_accessories' => 'Bath, Shower & Toilet Accessories',
            'bathroom_lighting' => 'Bathroom lighting',
        ),
        'kitchens' => array(
            'kitchen_cabinets_and_doors' => 'Kitchen Cabinets & Doors',
            'kitchen_cabinet_interiors' => 'Kitchen Cabinet Interiors',
            'kitchen_appliances' => 'Kitchen Appliances',
            'freestanding_kitchens' => 'Freestanding Kitchens',
            'modular_kitchens' => 'Modular Kitchens',
            'kitchen_worktops' => 'Kitchen Worktops',
            'kitchen_taps_and_sinks' => 'Kitchen Taps & Sinks',
            'wall_storage' => 'Wall Storage',
            'kitchen_wall_panels' => 'Kitchen Wall Panels',
            'kitchen_islands_and_trolleys' => 'Kitchen Islands & Trolleys',
            'step_stools_and_step_ladders' => 'Step stools & step ladders',
            'kitchen_integrated_lighting' => 'Kitchen Integrated Lighting',
            'pantry' => 'Pantry',
            'knobs_and_handles' => 'Knobs & handles',
        ),
        'childrens_ikea' => array(
            'baby' => 'Baby',
            'children_age_3_to_7' => 'Children (Age 3-7)',
            'children_age_8_to_12' => 'Children (Age 8-12)',
        ),
        'textiles_and_rugs' => array(
            'rugs' => 'Rugs',
            'bedding' => 'Bedding',
            'curtains_and_blinds' => 'Curtains & Blinds',
            'curtain_rails_and_rods' => 'Curtain Rails & Rods',
            'fabrics_and_sewing' => 'Fabrics & Sewing',
            'cushions_and_cushion_covers ' => 'Cushions & Cushion Covers ',
            'blankets_and_throws' => 'Blankets & throws',
            'kitchen_textiles' => 'Kitchen Textiles',
            'place_mats_and_dining_textiles' => 'Place Mats & Dining Textiles',
            'bathroom_textiles' => 'Bathroom textiles',
            'childrens_bedding_and_textiles' => 'Childrens Bedding & Textiles',
            'baby_textiles' => 'Baby Textiles',
            'mattress_and_pillow_protectors' => 'Mattress & pillow protectors',
        ),
        'home_office' => array(
            'desks_and_tables' => 'Desks & Tables',
            'office_chairs' => 'Office Chairs',
            'workspace_storage' => 'Workspace Storage',
            'bins_and_bags' => 'Bins & Bags',
            'paper_and_media_organisers' => 'Paper & Media Organisers',
            'lighting' => 'Lighting',
            'cable_management_and_accessories' => 'Cable management & accessories',
            'laminate_flooring' => 'Laminate Flooring',
        )
    ),

    'all_sub_categories' => function () {
            $out = array();
            $sub_categories = Config::get('product::sub_categories');
            if ($sub_categories) {
                foreach ($sub_categories as $category) {
                    $out += $category;
                }
            }
            return $out;
        },

    'all_categories' => function () {
            $out = array();
            $categories = Config::get('product::categories');
            asort($categories);
            $sub_categories = Config::get('product::sub_categories');
            if ($sub_categories) {
                foreach ($sub_categories as $key => $category) {

                    if (isset($categories[$key])){
                        asort($category);
                        $out[$categories[$key]] = $category;
                    }
                }
            }
            return $out;
        },
);