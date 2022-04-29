<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon\View\Components;

use App\Traits\LocaleTrait;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Block;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Category;
use GMJ\LaravelBlock2ThumbnailFilterIcon\Models\Config;
use Illuminate\View\Component;

class Frontend extends Component
{
    use LocaleTrait;

    public $element_id;
    public $page_element_id;
    public $collection;
    public $categories;
    public $locale;

    public function __construct($pageElementId, $elementId)
    {
        $this->page_element_id = $pageElementId;
        $this->element_id = $elementId;
        $this->categories = Category::where("element_id", $this->element_id)->get();
        $this->collection = Block::with("media")->where("element_id", $elementId)->orderBy("display_order")->get();
        $this->locale = $this->getLocale();
    }

    public function render()
    {
        $config = Config::where("element_id", $this->element_id)->first();
        $layout = $config->layout;
        return view("LaravelBlock2ThumbnailFilterIcon::components.{$layout}.frontend");
    }
}
