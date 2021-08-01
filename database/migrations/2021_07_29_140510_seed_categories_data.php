<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => 'Share',
                'description' => 'Share resources',
            ],
            [
                'name'        => 'Tutorials',
                'description' => 'Development skills, recommended extension packages, etc.',
            ],
            [
                'name'        => 'Q&A',
                'description' => 'Be friendly and help each other.',
            ],
            [
                'name'        => 'Announcement',
                'description' => 'All announcements',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
