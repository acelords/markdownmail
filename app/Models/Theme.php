<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Theme extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'colors'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'colors' => 'array',
    ];

    /**
     * Get the creator of the theme.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a list of colors based on the default colors and the current colors of the theme.
     *
     * @return \Illuminate\Support\Collection
     */
    public function generateColors()
    {
        $colors = Cache::remember('users', 60 * 60 * 24, function () {
            return Color::all();
        });

        return $colors->map(function (Color $color) {
            $customColor = isset($this->colors[$color->identifier]) ? $this->colors[$color->identifier] : null;

            return [
                'id' => $color->identifier,
                'color' => $customColor ?? $color->color,
                'category' => $color->category,
            ];
        });
    }
}
