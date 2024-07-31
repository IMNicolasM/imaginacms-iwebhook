<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IwebhooksAddColumnsInHookTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('iwebhooks__hooks', function (Blueprint $table) {
      $table->integer('status')->default(1)->unsigned()->after('id');
      $table->integer('type_id')->default(1)->unsigned()->after('id');
      $table->string('event_entity')->nullable()->after('category_id');
      $table->string('event_type_id')->nullable()->after('category_id');
    });
    Schema::table('iwebhooks__hook_translations', function (Blueprint $table) {
      $table->text('description')->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iwebhooks__hooks', function (Blueprint $table) {
      $table->dropColumn('status');
      $table->dropColumn('type_id');
      $table->dropColumn('event_type_id');
      $table->dropColumn('event_type');
    });
  }
}
