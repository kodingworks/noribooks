<?php

namespace App\Actions\Options;

use App\Models\Category;


class GetCategoryOptions
{
    public function handle()
    {
        $category = Category::pluck('name', 'id');

        return $category;
    }
}
