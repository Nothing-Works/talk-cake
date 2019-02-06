<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\Thread::class, 50)->create()->each(function (App\Thread $thread) {
            factory(App\Reply::class, 5)->create(['thread_id' => $thread->id]);
        });
    }
}
