<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbtfiCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lbtfi_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("element_id")->constrained("elements")->onDelete("cascade");
            $table->longText("title");
            $table->integer("display_order");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lbtfi_categories');
    }
}