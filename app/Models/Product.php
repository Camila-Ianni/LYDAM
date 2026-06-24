<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'stock',
        'image_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product): void {
            if (! $product->slug) {
                $values = is_array($product->name) ? $product->name : [];
                $name = $values['es'] ?? reset($values) ?: $product->name;

                $product->slug = Str::slug($name);
            }
        });
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function translatedName(?string $locale = null): string
    {
        return $this->translatedAttribute('name', $locale);
    }

    public function translatedDescription(?string $locale = null): string
    {
        return $this->translatedAttribute('description', $locale);
    }

    public function imageUrls(): array
    {
        if (! $this->image_path) {
            return [];
        }

        $paths = json_decode($this->image_path, true);
        if (! is_array($paths)) {
            $paths = [$this->image_path];
        }

        return array_map(function ($path) {
            if (Str::startsWith($path, ['http://', 'https://'])) {
                if (Str::contains($path, 'lh3.googleusercontent.com') && ! Str::contains($path, '=')) {
                    return $path . '=s0';
                }
                return $path;
            }
            return asset('storage/'.$path);
        }, $paths);
    }

    public function imageUrl(): ?string
    {
        $urls = $this->imageUrls();
        return $urls[0] ?? null;
    }

    private function translatedAttribute(string $attribute, ?string $locale = null): string
    {
        $values = $this->{$attribute} ?? [];
        $locale = $locale ?: app()->getLocale();

        return $values[$locale] ?? $values['es'] ?? reset($values) ?: '';
    }
}
