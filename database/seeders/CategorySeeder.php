<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Blog\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    //use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'=>'Nguyen the truong',
            'type'=>CategoryType::Category
        ]);
    }
}
