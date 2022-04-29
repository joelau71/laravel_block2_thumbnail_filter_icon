<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon\Models;

use App\Traits\DeleteAllChildrenTrait;
use App\Traits\DeleteElementLinkPageTrait;
use App\Traits\ElementLinkPageTrait;
use App\Traits\GrabImageFromUnsplashTrait;
use App\Traits\IconManagementOneTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Block extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use ElementLinkPageTrait;
    use DeleteAllChildrenTrait;
    use GrabImageFromUnsplashTrait;
    use DeleteElementLinkPageTrait;
    use IconManagementOneTrait;

    protected $guarded = [];
    public $translatable = ['title', 'text'];
    public $table = "laravel_block2_thumbnail_filter_icons";

    public function categories()
    {
        return $this->belongsToMany(Category::class, "lbtfi_category_item", "item_id", "category_id")->orderBy("display_order");
    }

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection("laravel_block2_thumbnail_filter_icon")
            ->singleFile();

        $this->addMediaCollection("laravel_block2_thumbnail_filter_icon_original")
            ->singleFile();
    }
}
