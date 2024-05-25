<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteContentManagementsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('site_content_managements', function (Blueprint $table) {
            $table->id();
            $table->string('code');                       
            $table->text('value')->nullable();   
            $table->text('remark')->nullable();   
                               
            $table->timestamps();
            $table->softDeletes();
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('site_content_managements');
    }
}
