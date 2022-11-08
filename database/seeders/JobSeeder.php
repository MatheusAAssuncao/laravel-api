<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Language;
use App\Models\Tool;
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

        $allLanguages = $allTools = [];
        foreach ($data as $job) {
            $allLanguages = array_unique(array_merge($job['languages'], $allLanguages));
            $allTools = array_unique(array_merge($job['tools'], $allTools));
        }
        
        foreach ($allLanguages as $language) {
            Language::create([
                'name' => $language,
            ]);
        }

        foreach ($allTools as $tool) {
            Tool::create([
                'name' => $tool,
            ]);
        }

        foreach ($data as $job) {
            $_job = Job::findOrFail($job['id']);
            $_job->languagesMany()->attach(Language::where('name', $job['languages'])->get());
            $_job->toolsMany()->attach(Tool::whereIn('name', $job['tools'])->get());
        }
    }
}
