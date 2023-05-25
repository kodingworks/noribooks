<?php

namespace App\Actions\Options;

use App\Models\Category;


class GetCategoryOptions
{
    public function codeHandle()
    {
        $categoryCode = Category::pluck('code',  'id');

        return $categoryCode;
    }
    public function handle()
    {
        $categoryName = Category::pluck('name',  'id');

        return $categoryName;
    }
}
