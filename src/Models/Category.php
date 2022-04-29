<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $guarded = [];
    public $translatable = ['title'];
    public $table = "lbtfi_categories";

    public function thumbnail_filter_icons()
    {
        return $this->belongsToMany(Block::class, "lbtfi_category_item", "category_id", "item_id")->orderBy("display_order");
    }
}
