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
                'username' => 'thiendum',
                'password' => '123456',
                'name' => 'Thien',
                'email' => 'thien@pizza.com',
                'address' => '123abc',
                'phone' => '0123456789',
                'role' => 'admin',
            ],
            [
                'username' => 'admin1',
                'password' => '123456',
                'name' => 'ADMIN 1',
                'email' => 'admin1@pizza.com',
                'address' => '123abc',
                'phone' => '0123456789',
                'role' => 'admin',
            ],
            [
                'username' => 'admin2',
                'password' => '123456',
                'name' => 'ADMIN 2',
                'email' => 'admin2@pizza.com',
                'address' => '123abc',
                'phone' => '0123456789',
                'role' => 'admin',
            ],
            [
                'username' => 'admin3',
                'password' => '123456',
                'name' => 'ADMIN 3',
                'email' => 'admin3@pizza.com',
                'address' => '123abc',
                'phone' => '0123456789',
                'role' => 'admin',
            ],    

        ]);

        //Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->bigInteger('price');
            $table->integer('type_id');
            $table->string('image', 100);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('types');
        });
        DB::table('products')->insert([
            [
                'name' => 'Pizza 1',
                'price' => 99000,
                'type_id' => '1',
                'image' => 'pizza1.png',
            ],
            [
                'name' => 'Cake 1',                
                'price' => 50000,
                'type_id' => '2',
                'image' => 'cake1.png',
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

        
        //Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prices');
            $table->string('note', 20);
            $table->date('date');
            $table->bigInteger('user_id')->unsigned();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        // DB::table('bills')->insert([
        //     [
        //         'prices' => 99000,
        //         'note' => 'delivering',
        //         'date' => '25/05/2021',
        //         'user_id' => 1,
        //     ],
        // ]);

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
        // DB::table('detail_bill')->insert([
        //     [
        //         'prices' => 99000,
        //         'count' => 1,
        //         'product_id' => 1,
        //         'bill_id' => 1,
        //     ],
        // ]);
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
        Schema::dropIfExists('bills');
        Schema::dropIfExists('detail_bill');
    }
}
