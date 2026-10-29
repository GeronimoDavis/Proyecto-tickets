<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*mejor forma 
        
            $users = User::factory(10)->create();

            SupportTicket::factory(20)
            ->recycle($users)
            ->create(); 
        */

       $this->call([
            UserSeeder::class,
            SupportTicketSeeder::class
        ]);
    }
}
