<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $max = Type::count();
        for ($i = 0; $i < 6; $i++) {
            $project = new Project();
            $project->type_id = $faker->numberBetween(1, $max);
            $project->title = $faker->words(3, true);
            $project->project_url = $faker->url();
            // $project->image_url = $faker->imageUrl(150, 150);
            $project->description = $faker->paragraphs(2, true);
            $project->slug = Str::slug($project->title, '-');
            $project->is_published = $faker->boolean;
            $project->save();
        }
    }
}
