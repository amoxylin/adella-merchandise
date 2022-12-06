<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table
                ->integer("category_id")
                ->nullable(false)
                ->default(0);
            $table
                ->integer("manufacturer_id")
                ->nullable(false)
                ->default(0);
            $table->string("name")->nullabe(false);
            $table->integer("price")->nullabe(false);
            $table->integer("stock")->nullabe(false);
            $table->softDeletes();
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
        Schema::dropIfExists("products");
    }
};
