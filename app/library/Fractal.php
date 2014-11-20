<?php

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;


//use League\Fractal\Serializer\DataArraySerializer;

use Illuminate\Pagination\Paginator as IlluminatePaginator;

//
//Formatting a collection:
//
//// routes.php
//Route::get('/comments', function () {
//    return Fractal::collection(Comment::all(), new CommentTransformer);
//});
//Paginating a collection:
//
//// routes.php
//Route::get('/comments', function () {
//    $paginator = Comment::paginate();
//    $comments = $paginator->getCollection();
//
//    return Fractal::collection($comments, new CommentTransformer, $paginator);
//});

class Fractal
{
    private $manager;
    private $responseFunction = null;
    private $data = null;
    private $recursionLimit = 100;

    public function __construct()
    {
        $this->manager = new Manager;
    }

    public function setSerializer($serializer)
    {
        $this->manager->setSerializer($serializer);
    }

    public function setRecursionLimit($limit)
    {
        $this->recursionLimit = $limit;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function setResponseRaw($bool)
    {
        $this->responseRaw = $bool;
    }

    public function parseIncludes($includes)
    {
        $this->manager->parseIncludes($includes);
    }

    public function item($item, TransformerAbstract $transformer)
    {
        $this->manager->setRecursionLimit($this->recursionLimit);
        $resource = new Item($item, $transformer);
        $this->buildResponse($resource);
        return $this;
    }

    public function setResponseFunction($closure)
    {
        $this->responseFunction = $closure;
    }

    public function collection($items, TransformerAbstract $transformer, IlluminatePaginator $paginator = null)
    {
        $this->manager->setRecursionLimit($this->recursionLimit);
        $resource = new Collection($items, $transformer);

        if ($paginator) {
            $adapter = new IlluminatePaginatorAdapter($paginator);
            $resource->setPaginator($adapter);
        }

        $this->buildResponse($resource);
        return $this;
    }

    private function buildResponse(ResourceInterface $resource)
    {
        $this->data = $this->manager->createData($resource);
    }

    public function response()
    {
        return Response::make($this->data->toArray());
    }

    public function getData()
    {
        return $this->data;
    }
}