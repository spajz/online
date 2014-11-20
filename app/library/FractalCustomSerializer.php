<?php

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\SerializerAbstract;

class FractalCustomSerializer extends SerializerAbstract
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    public function includedData($resourceKey, array $data)
    {
        return [$resourceKey => $data];
    }

    public function item($resourceKey, array $data)
    {
        return $data;
    }

    public function meta(array $meta)
    {
        if (empty($meta)) {
            return array();
        }

        return ['stuff' => $meta];
    }

    public function paginator(PaginatorInterface $paginator)
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage = (int) $paginator->getLastPage();

        $links = [];

        if ($currentPage > 1) {
            $links['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $links['next'] = $paginator->getUrl($currentPage + 1);
        }

        return ['pages' => $links];
    }

    public function cursor(CursorInterface $cursor)
    {
        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev' => $cursor->getPrev(),
            'next' => $cursor->getNext(),
            'count' => (int) $cursor->getCount(),
        ];

        return ['cursor' => $cursor];
    }
}