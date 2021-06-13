<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $date = new DateTime();
        $unixTimestamp = $date->getTimestamp();

        //Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20);
            $table->string('password', 20);
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('address', 100);
            $table->string('phone', 11);
            $table->string('role', 10);
        });
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => '123',
                'name' => 'ADMIN',
                'email' => 'admin@pizza.com',
                'address' => '123abc',
                'phone' => '0123456789',
                'role' => 'admin',
            ],
            [
                'username' => 'thiendum',
                'password' => '123',
                'name' => 'Thien',
                'email' => 'thien@pizza.com',
                'address' => '123 abc xyz',
                'phone' => '0123456789',
                'role' => 'customer',
            ],
        ]);

        //Types
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        });
        DB::table('types')->insert([
            [
                'name' => 'pizza',
            ],
            [
                'name' => 'cake',
            ],
        ]);

        //Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->bigInteger('price');
            $table->bigInteger('type_id')->unsigned();
            $table->string('image', 100);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('types');
        });


        //Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prices');
            $table->string('note', 20);
            $table->string('date');
            $table->bigInteger('user_id')->unsigned();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });


        //DetailBill
        Schema::create('detail_bill', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->bigInteger('prices');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('bill_id')->unsigned();
        });
        Schema::table('detail_bill', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('bill_id')->references('id')->on('bills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('products');
        Schema::dropIfExists('types');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('detail_bill');

    }
}
