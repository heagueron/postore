<?php

use Illuminate\Database\Seeder;

use App\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TwitterProfilesTableSeeder::class);
        //$this->call(StweetsTableSeeder::class);
        $this->call(SpostsTableSeeder::class);
        $this->call(SpostTwitterProfileTableSeeder::class);

        // Remote Jobs
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(RemjobSeeder::class);  
        //$this->call(RemjobTagSeeder::class);

        // Seed main categories:
        $mainCategories = ['dev', 'customer-support', 'marketing', 'design', 'non-tech'];
        foreach( $mainCategories as $mc ){

            $tag = Tag::where( 'name', '=', $mc )->first();
            if ($tag === null) {
                // tag doesn't exist
                $newTag = new Tag();
                $newTag->name = $mc;
                $newTag->save();
            }
            
        }

        // Register in pivot tables

        foreach(App\Remjob::all() as $remjob) {

            $tagCount = rand(1,5);

            $randomTags = App\Tag::all()->random( $tagCount );

            foreach( $randomTags as $randomTag){
                $remjob->tags()->attach($randomTag->id);
            }
            
        }

    }
}
