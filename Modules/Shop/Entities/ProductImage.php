<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductImage extends Model implements HasMedia
{
    use HasFactory, UuidTrait, InteractsWithMedia;

    protected $table = 'shop_product_images';

    protected $fillable = [
        'product_id',
        'name',
    ];

    public const DEFAULT_IMAGE = 'https://placehold.co/150x150?text=No+Image';
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductImageFactory::new();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('img-thumb')->width(150)->height(150);
        $this->addMediaConversion('img-medium')->width(280)->height(400);
        $this->addMediaConversion('img-lage')->width(675)->height(1024);
    }
}
