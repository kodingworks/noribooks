<?php

namespace App\Http\Resources\Accounting\Account;

use Carbon\Carbon;
use App\Services\FileService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collection),
            'meta' => [
                "success" => true,
                "message" => "Success get account lists",
                'pagination' => $this->metaData()
            ]
        ];
    }

    private function transformData($data)
    {

        return [
            'id' => $data->id,
            'category_code' => $data->category->code,
            'name' => $data->name,
            'number' => $data->number,
            'category_id' => $data->category_id,
            'category_name' => $data->category->name,
            'type' => $data->type,
            'description' => $data->description,
        ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int)$this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }
}
