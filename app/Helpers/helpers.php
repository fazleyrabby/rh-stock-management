<?php


if (!function_exists('setPaginationMetaData')) {
    function setPaginationMetaData($items)
    {
        return [
            'current_page' => $items->currentPage(),
            'last_page'    => $items->lastPage(),
            'per_page'     => $items->perPage(),
            'total'        => $items->total(),
            'links'        => [
                'first' => $items->url(1),
                'last'  => $items->url($items->lastPage()),
                'prev'  => $items->previousPageUrl(),
                'next'  => $items->nextPageUrl(),
            ]
        ];
    }
}
