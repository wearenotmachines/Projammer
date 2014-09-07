<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalIdToClient extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("clients", function($table) {
			$table->integer("external_id")->unsigned()->nullable();
			$table->index("external_id", "i_client_external");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("clients", function($table) {
			$table->dropColumn("external_id");
			$table->dropIndex("i_client_external");
		});
	}

}
