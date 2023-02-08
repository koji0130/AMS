<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ユーザー情報
        /*DB::table('users')->insert([
            [
                'username' => 'トマト',
                'mail' => 'tomato@gmail.com',
                'password' => 'tomato0000',
                'bio' => '私は美味しいトマトです。',
            ],

        ]);*/

        /*ユーザー情報*/
        DB::table('users')->insert([
            [
                'username' => 'トマト',
                'mail' => 'tomato@gmail.com',
                'password' => bcrypt('tomato0000'),
                'bio' => '私は美味しいトマトです。',
            ],

        ]);
    }
}
