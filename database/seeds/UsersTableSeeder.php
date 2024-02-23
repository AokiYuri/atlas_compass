<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初期ユーザー
        DB::table('users')->insert([
            [
                'over_name' => 'Divus',
                'under_name' => 'Crewel',
                'over_name_kana' => 'デイヴィス',
                'under_name_kana' => 'クルーウェル',
                'mail_address' => 'Crewel@gmail.com',
                'sex' => '1',
                'birth_day' => '19610125',
                'role' => '3',
                'password' => bcrypt('Crewel')
            ]
        ]);
    }
}
