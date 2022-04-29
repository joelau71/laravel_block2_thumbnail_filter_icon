<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Element;
use App\Models\Icon;
use App\Models\Page;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Block;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Category;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Config;
use Illuminate\Validation\Rule;

class BlockController extends Controller
{
    public function index($element_id)
    {

        $config = Config::where("element_id", $element_id)->first();
        if (!$config) {
            return redirect()->route("LaravelBlock2ThumbnailFilterIcon.config.create", $element_id);
        }

        $element = Element::findOrFail($element_id);
        $collections = Block::where("element_id", $element_id)->orderBy("display_order")->get();

        return view('LaravelBlock2ThumbnailFilterIcon::index', compact("element_id", "element", "collections"));
    }

    public function create($element_id)
    {
        $element = Element::findOrFail($element_id);
        $pages = Page::all();
        $config = Config::where("element_id", $element_id)->first();
        $categories = Category::where("element_id", $element_id)->orderBy("display_order")->get();
        $icons = Icon::orderBy("display_order")->get();
        //dd($icons);
        return view('LaravelBlock2ThumbnailFilterIcon::create', compact("element_id", "element", "config", "categories", "icons", "pages"));
    }

    public function store($element_id)
    {

        $element = Element::findOrFail($element_id);

        //dd(request()->category);

        request()->validate(
            [
                "image" => ["required", "image", "mimes:jpeg,jpg,png,webp"],
                "category" => ["required", "array"],
                "category.*" => ["required", "integer", Rule::exists('lbtfi_categories', 'id')],
                "icon" => ["required", "integer", Rule::exists('icons', 'id')],
                "title.*" => ["required", "max:255"],
                "text.*" => ["required", "max:500"],
            ]
        );

        $display_order = Block::where("element_id", $element_id)->max("display_order");
        $display_order++;

        $collection = Block::create([
            "element_id" => $element_id,
            "title" => request()->title,
            "text" => request()->text,
            "display_order" => $display_order
        ]);

        $collection->addMediaFromRequest('image')->toMediaCollection('laravel_block2_thumbnail_filter_icon_original');

        //$collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->withResponsiveImages()->toMediaCollection('laravel_block2_thumbnail_filter_icon');
        $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->toMediaCollection('laravel_block2_thumbnail_filter_icon');

        $collection->categories()->sync(request()->category);

        $collection->iconManagement()->create([
            "icon_id" => request()->icon,
        ]);

        if (request()->custom_link || request()->page_id) {
            $collection->elementLinkPage()->create([
                "element_id" => $element->id,
                "page_id" => request()->page_id,
                "is_custom_link" => boolval(request()->is_custom_link),
                "is_external" => boolval(request()->is_external),
                "custom_link" => request()->custom_link
            ]);
        }

        $element->active();

        Alert::success("Add Element {$element->title} Shop Address Filter success");
        return back();
    }

    public function edit($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $config = Config::where("element_id", $element_id)->first();
        $categories = Category::where("element_id", $element_id)->orderBy("display_order")->get();
        $icons = Icon::orderBy("display_order")->get();
        $pages = Page::all();
        $collection = Block::findOrFail($id);
        $selected = $collection->categories()->pluck("category_id")->toArray();
        //dd($icons);
        return view('LaravelBlock2ThumbnailFilterIcon::edit', compact("element_id", "element", "config", "categories", "icons", "collection", "selected", "pages"));
    }

    public function update($element_id, $id)
    {

        $element = Element::findOrFail($element_id);

        request()->validate(
            [
                "image" => ["image", "mimes:jpeg,jpg,png,webp"],
                "category" => ["required", "array"],
                "category.*" => ["required", "integer", Rule::exists('lbtfi_categories', 'id')],
                "icon" => ["required", "integer", Rule::exists('icons', 'id')],
                "title.*" => ["required", "max:255"],
                "text.*" => ["required", "max:500"],
            ]
        );

        $collection = Block::findOrFail($id);

        $collection->update([
            "title" => request()->title,
            "text" => request()->text,
        ]);

        if (request()->image) {
            $collection->addMediaFromRequest('image')->toMediaCollection('laravel_block2_thumbnail_filter_icon_original');
        }

        if (request()->uic_base64_image) {
            // $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->withResponsiveImages()->toMediaCollection('laravel_block2_thumbnail_filter_icon');
            $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->toMediaCollection('laravel_block2_thumbnail_filter_icon');
        }

        $collection->categories()->sync(request()->category);

        $collection->iconManagement()->delete();
        $collection->iconManagement()->create([
            "icon_id" => request()->icon,
        ]);

        $collection->elementLinkPage()->delete();
        if (request()->custom_link || request()->page_id) {
            $collection->elementLinkPage()->create([
                "element_id" => $element->id,
                "page_id" => request()->page_id,
                "is_custom_link" => boolval(request()->is_custom_link),
                "is_external" => boolval(request()->is_external),
                "custom_link" => request()->custom_link
            ]);
        }

        Alert::success("Edit Element {$element->title} Thumbnail Filter Icon success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.index', $element_id);
    }

    public function order($element_id)
    {
        $element = Element::find($element_id);
        $collections = Block::where("element_id", $element_id)->orderBy("display_order")->get();
        return view("LaravelBlock2ThumbnailFilterIcon::order", compact("element_id", "element", "collections"));
    }

    public function order2($element_id)
    {
        foreach (request()->id as $key => $item) {
            $collection = Block::find($item);
            $num = $key + 1;
            $collection->display_order = $num;
            $collection->save();
        }
        $element = Element::find($element_id);
        Alert::success("Edit Element {$element->title} Shop Address Filter Order success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.index', $element_id);
    }

    public function destroy($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Block::findOrFail($id);

        $collection->delete();

        if ($collection->count() < 1) {
            $element->inactive();
        }
        Alert::success("Delete Element {$element->title} Thumbnail Filter Icon success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.index', $element_id);
    }
}
