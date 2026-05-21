<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceViewHelper
{
    public static function paginate(ResourceCollection $resource, Request $request): array
    {
        $links = $resource->resource->toArray();

        unset($links['data']);

        return [
            'data' => $resource->collection->map->toArray($request),
            'paginator' => [
                "current_page" => $resource->currentPage(),
                "links" =>   $links['links'] ?? [],
                "first_page_url" => $resource->url(1),
                "from" => $resource->firstItem(),
                "last_page" => $resource->lastPage(),
                "last_page_url" => $resource->url($resource->lastPage()),
                "next_page_url" => $resource->nextPageUrl(),
                "path" => $resource->path(),
                "per_page" => $resource->perPage(),
                "prev_page_url" => $resource->previousPageUrl(),
                "to" => $resource->lastItem(),
                "total" => $resource->total(),
            ]
        ];
    }
}
