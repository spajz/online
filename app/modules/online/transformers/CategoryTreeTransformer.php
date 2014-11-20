<?php namespace Online\Transformers;

use Online\Models\Category;
use League\Fractal;

class CategoryTreeTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'children'
    ];

    protected $defaultIncludes = [
        'children'
    ];

    public function transform($item)
    {
        $return = [
            'id' => $item['data']['id'],
            // 'title' => $item['title'],
            'sort' => $item['data']['sort'],
            // 'sort' => $item['sort'],
            //    'parent_id' => $item['data']['parent_id'] == 0 ? null : $item['data']['parent_id'],
            // 'children' => isset($item['children']) ? $item['children'] : array(),
        ];

        return $return;
    }

    public function includeChildren($include)
    {
        if (!isset($include['children'])) return null;

        return $this->collection($include['children'], new CategoryTreeTransformer);
    }
}
