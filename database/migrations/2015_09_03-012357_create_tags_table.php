<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagsTable extends Migration
{
    /**
     * Table names
     */
    private $table;
    private $table_pivot;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->table       = config('tags.table');
        $this->table_pivot = config('tags.table_pivot');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table)
		{
		    $table->increments('id');

            $table->string('tag')->unique();
            $table->string('slug')->unique();
            // TODO: check wether to add suggestions
            // $table->boolean('suggest')->default(false);
            // TODO: add tag language locale
            // $table->string('locale');

            $table->timestamps();
            $table->softDeletes();
		});

        Schema::create($this->table_pivot, function(Blueprint $table)
        {
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')
                ->references('id')
                ->on($this->table)
                ->onDelete('cascade');

            $table->integer('taggable_id')->unsigned()->index();
            $table->string('taggable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table_pivot);
        Schema::drop($this->table);
    }
}
