<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

Schema::table('employees', function (Blueprint $table) {
    // Remove the existing foreign key constraint
    $table->dropForeign('employees_company_id_foreign');

    // Add a new foreign key constraint with ON DELETE CASCADE
    $table->foreign('company_id')
          ->references('id')
          ->on('companies')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
