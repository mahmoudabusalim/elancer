<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('categoties', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        schema::create('categories',function(Blueprint $table){
            // id UNSIGNED BIGINT AUTO INCREMNT PRIMARY
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // $table->bigIncrements("id")->primary();
            $table->id();
            //nmae varchar(50) unique
            $table->string('name',50)->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('art_path')->nullable();

            // $table->unsignedBigInteger('parent_id')->nullable();
            // $table->foreign('parent_id')->references('id')->on('categories')
            // ->nullOnDelete(); //onDelete('null);
             $table->foreignId('parent_id')
             ->nullable()
             ->constrained('categories','id')
             ->nullOnDelete();



            //creared_at  timestamp null
            //updated_at  timestanp null

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
