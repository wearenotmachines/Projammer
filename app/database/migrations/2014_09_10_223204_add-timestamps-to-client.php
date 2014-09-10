<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToClient extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("clients", function($table) {
			$table->integer("created_by")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("created_by", "fk_client_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
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
			$table->dropForeign("fk_client_creator");
			$table->dropColumn("created_by");
			$table->dropColumn("created_at");
			$table->dropColumn("updated_at");
			$table->dropColumn("deleted_at");
		});
	}

}
