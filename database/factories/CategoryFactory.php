<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    private static $categories = [
        ['name' => 'Электроника', 'description' => 'Смартфоны, планшеты, ноутбуки и аксессуары'],
        ['name' => 'Одежда', 'description' => 'Мужская и женская одежда, обувь'],
        ['name' => 'Дом и сад', 'description' => 'Мебель, декор, товары для дома'],
        ['name' => 'Спорт', 'description' => 'Спортивный инвентарь и одежда'],
        ['name' => 'Книги', 'description' => 'Художественная и техническая литература'],
        ['name' => 'Красота', 'description' => 'Косметика и парфюмерия'],
    ];

    private static $index = 0;

    public function definition()
    {
        if (self::$index >= count(self::$categories)) {
            self::$index = 0;
        }
        
        $category = self::$categories[self::$index];
        self::$index++;
        
        return $category;
    }
}
