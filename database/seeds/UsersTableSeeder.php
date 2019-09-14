<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'first_name' => 'Frank',
          'last_name' => 'Hadley',
          'role' => 'Influencer',
          'company' => 'Mets',
          'email' => 'frank@mets.com',
          'password' => bcrypt('password'),
      ]);

      DB::table('users')->insert([
          'first_name' => 'Bob',
          'last_name' => 'Bobson',
          'role' => 'Sponsor',
          'company' => 'Nike',
          'email' => 'bob@nike.com',
          'password' => bcrypt('password'),
      ]);
    }
}
