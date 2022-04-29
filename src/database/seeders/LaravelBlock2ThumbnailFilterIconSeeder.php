<?php

namespace Database\Seeders;

use App\Models\Element;
use App\Models\ElementTemplate;
use App\Models\Icon;
use Illuminate\Database\Seeder;
use Faker\Factory;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Block;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Category;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Config;
use Illuminate\Support\Arr;
use Image;

class LaravelBlock2ThumbnailFilterIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageSubject = "bathroom";
        $template = ElementTemplate::where("component", "LaravelBlock2ThumbnailFilterIcon")->first();

        if ($template) {
            return false;
        }

        $template = ElementTemplate::create(
            [
                "title" => "Laravel Block2 Thumbnail Filer Icon",
                "component" => "LaravelBlock2ThumbnailFilterIcon",
            ]
        );
        $element = Element::create([
            "template_id" => $template->id,
            "title" => "laravel-block2-thumbnail-filter-icon-sample",
            "is_active" => 1
        ]);

        $faker = Factory::create();

        $config = Config::create([
            "element_id" => $element->id,
            "img_width" => 328,
            "img_height" => 255,
            "layout" => "3-column"
        ]);

        for ($i = 1; $i < 6; $i++) {
            foreach (config('translatable.locales') as $locale) {
                $title[$locale] = $faker->word(1);
            }
            Category::create([
                "element_id" => $element->id,
                "title" => $title,
                "display_order" => $i
            ]);
        }

        $categories = Category::all()->pluck("id")->toArray();
        $icons = Icon::all()->pluck("id")->toArray();

        for ($i = 1; $i < 22; $i++) {
            $title = [];
            $text = [];

            foreach (config('translatable.locales') as $locale) {
                $title[$locale] = $faker->name;
                $text[$locale] = $faker->paragraph;
            }

            $collection = Block::create([
                "element_id" => $element->id,
                "title" => $title,
                "text" => $text,
                "display_order" => $i
            ]);

            $url = "https://source.unsplash.com/{$config->img_width}x{$config->img_height}/?{$imageSubject}";
            $path = "demo/temp.jpg";

            $collection->grabImageFromUnsplash($url, $path);

            $collection->addMedia(storage_path($path))
                ->preservingOriginal()
                ->toMediaCollection("laravel_block2_thumbnail_filter_icon_original");

            $collection->addMedia(storage_path($path))->toMediaCollection("laravel_block2_thumbnail_filter_icon");

            $selected = Arr::random($categories, 2);
            $collection->categories()->sync($selected);
            $icon_id = Arr::random($icons);
            $collection->iconManagement()->create([
                "icon_id" => $icon_id,
            ]);
        }
    }
}
