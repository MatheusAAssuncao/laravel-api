<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/data.json'));
        $data = json_decode($json, true);

        foreach ($data as $job) {
            Job::create([
                'company' => $job['company'],
                'logo' => $job['logo'],
                'new' => $job['new'],
                'featured' => $job['featured'],
                'position' => $job['position'],
                'role' => $job['role'],
                'level' => $job['level'],
                'postedAt' => $job['postedAt'],
                'contract' => $job['contract'],
                'location' => $job['location'],
            ]);
        }

        // foreach ($data as $user) {
        //     foreach ($user['connections'] as $connection) {
        //         UserConnection::create([
        //             'user_id' => $user['id'],
        //             'friend_id' => $connection,
        //         ]);
        //     }
        // }
    }
}
