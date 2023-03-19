<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'over_name' => '苗字',
            'under_name' => '名前',
            'over_name_kana' => 'ミョウジ',
            'under_name_kana' => 'ナマエ',
            'mail_address' => 'ppp@ppp',
            'sex' => '1',
            'birth_day' => '2001-02-22',
            'role' => '2',
            'password' => Hash::make('password'),
        ]);
    }
}
