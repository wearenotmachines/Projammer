<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelaxFkOnProjectClient extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE projects CHANGE COLUMN client_id client_id INT UNSIGNED NULL");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE projects CHANGE COLUMN client_id client_id INT UNSIGNED NOT NULL");
	}

}
