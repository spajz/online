<?php namespace Online\Transformers;

use Online\Models\Category;
use League\Fractal;

class CategoryTransformer extends Fractal\TransformerAbstract
{
//    protected $availableIncludes = [
//        'children'
//    ];

    protected $defaultIncludes = [
        'children'
    ];

    public function transform(Category $item)
    {
        $sufix = '';
//        $children = count($item->getImmediateDescendants());
//        $allChildren = count($item->getDescendants());
//        if($children) $sufix .= ' [' . $children . ']';
//        if($allChildren) $sufix .= ' [' . $allChildren . ']';

        return [
            'id' => (int)$item->id,
            'title' => $item->title . $sufix,
            'parent_id' => $item->parent_id,
            'sort' => $item->sort,
            'folder' => true,
        ];
    }

    public function includeChildren(Category $item)
    {
        return $this->collection($item->children, new CategoryTransformer);
    }

}
