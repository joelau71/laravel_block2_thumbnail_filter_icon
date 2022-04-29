<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbtfiCategoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lbtfi_category_item', function (Blueprint $table) {
            $table->foreignId("category_id")->constrained("lbtfi_categories")->onDelete("cascade");
            $table->foreignId("item_id")->constrained("laravel_block2_thumbnail_filter_icons")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lbtfi_category_item');
    }
}
