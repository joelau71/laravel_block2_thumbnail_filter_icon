<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Element;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index($element_id)
    {
        $element = Element::findOrFail($element_id);
        $collections = Category::where("element_id", $element_id)->orderBy("display_order")->get();

        return view('LaravelBlock2ThumbnailFilterIcon::category.index', compact("element_id", "element", "collections"));
    }

    public function create($element_id)
    {
        $element = Element::findOrFail($element_id);
        return view('LaravelBlock2ThumbnailFilterIcon::category.create', compact("element_id", "element"));
    }

    public function store($element_id)
    {

        $element = Element::findOrFail($element_id);

        request()->validate(
            [
                "title.*" => ["required"],
            ]
        );

        $display_order = Category::where("element_id", $element_id)->max("display_order");
        $display_order++;

        Category::create([
            "element_id" => $element_id,
            "title" => request()->title,
            "display_order" => $display_order
        ]);

        Alert::success("Add Element {$element->title} Shop Address Filter Category success");
        return back();
    }

    public function edit($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Category::findOrFail($id);
        return view('LaravelBlock2ThumbnailFilterIcon::category.edit', compact("element_id", "element", "collection"));
    }

    public function update($element_id, $id)
    {

        $element = Element::findOrFail($element_id);

        request()->validate(
            [
                "title.*" => ["required"],
            ]
        );

        $category = Category::findOrFail($id);

        $category->update([
            "title" => request()->title,
        ]);

        Alert::success("Edit Element {$element->title} Shop Address Filter Category success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.category.index', $element_id);
    }

    public function order($element_id)
    {
        $element = Element::find($element_id);
        $collections = Category::where("element_id", $element_id)->orderBy("display_order")->get();
        return view("LaravelBlock2ThumbnailFilterIcon::category.order", compact("element_id", "element", "collections"));
    }

    public function order2($element_id)
    {
        foreach (request()->id as $key => $item) {
            $collection = Category::find($item);
            $num = $key + 1;
            $collection->display_order = $num;
            $collection->save();
        }
        $element = Element::find($element_id);
        alert()->success("Edit Element {$element->title} Shop Address Filter Order success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.category.index', $element_id);
    }

    public function destroy($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Category::findOrFail($id);
        $collection->delete();

        //Alert::success("Delete Element {$element->title} Shop Address Filter Category success");
        return redirect()->route('LaravelBlock2ThumbnailFilterIcon.category.index', $element_id);
    }
}
