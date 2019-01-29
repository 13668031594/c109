<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(DefaultMaster::class);
//        $this->call(DefaultPrompt::class);
//        $this->call(DefaultMemberAccount::class);
        $this->call(DefaultMemberRank::class);
        $this->call(DefaultCustomer::class);
    }
}
