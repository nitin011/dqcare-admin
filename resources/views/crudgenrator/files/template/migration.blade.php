<{{ $data['wildcard'] }}php
/**
 * Class {{ $migration_name }}Table
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{{ $migration_name }}Table extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $data["name"] }}', function (Blueprint $table) {
            $table->id();
            @foreach($data['fields']['name'] as $index => $item)@if( $data['fields']['default'][$index] == 1)$table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{{ $data['fields']['comment'][$index] }}');                       
                @elseif( $data['fields']['default'][$index] == 2)$table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->nullable()->comment('{{ $data['fields']['comment'][$index] }}');   
                @elseif( $data['fields']['default'][$index] == 3 )$table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->default(0)->comment('{{ $data['fields']['comment'][$index] }}');   
                @elseif( $data['fields']['default'][$index] == 4 )$table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->default(1)->comment('{{ $data['fields']['comment'][$index] }}');   
                @endif @endforeach
              
            $table->timestamps();
            @if(isset($data['softdelete']))
                $table->softDeletes();
            @endif
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $data["name"] }}');
    }
}
