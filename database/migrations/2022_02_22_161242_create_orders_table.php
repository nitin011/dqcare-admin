
<?php
/**
 * Class OrdersTable
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');                       
                 $table->string('txn_no');                       
                 $table->float('discount')->nullable();   
                 $table->integer('tax')->nullable();   
                 $table->float('sub_total');                       
                 $table->float('total');                       
                 $table->integer('status')->default(0);   
                 $table->string('payment_gateway')->nullable();   
                 $table->text('remarks')->nullable();   
                 $table->json('from')->nullable();   
                 $table->json('to')->nullable();   
                               
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
        Schema::dropIfExists('orders');
    }
}
