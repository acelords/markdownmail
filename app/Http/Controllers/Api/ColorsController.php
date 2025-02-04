<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;
use App\Http\Controllers\ApiController;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ColorsController extends ApiController
{
    /**
     * @param Theme $theme
     * @return \Illuminate\Support\Collection
     */
    public function show(Theme $theme)
    {
        return $theme->generateColors()->groupBy('category');
    }

    /**
     * @param Request $request
     * @param Theme $theme
     * @param $identifier
     * @return mixed
     */
    public function patch(Request $request, Theme $theme, $identifier)
    {
        $colors = $theme->colors;

        if (!is_array($colors)) {
            $colors = [];
        }

        $theme->update([
            'colors' => array_merge($colors, [$identifier => $request->color]),
        ]);

        // refresh cache
        Cache::forget('colors');

        return $theme->colors;
    }
}
