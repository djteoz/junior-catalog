<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private static $products = [
        // Электроника (4 товара)
        ['name' => 'iPhone 15 Pro', 'description' => 'Смартфон Apple с чипом A17 Pro, 256 ГБ, титановый корпус', 'price' => 124990, 'image' => 'https://cdn.dummyjson.com/products/images/smartphones/iPhone%2013%20Pro/1.png', 'category' => 'Электроника'],
        ['name' => 'Samsung Galaxy S24', 'description' => 'Флагманский смартфон Samsung с AI-функциями и камерой 200 МП', 'price' => 89990, 'image' => 'https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S10/1.png', 'category' => 'Электроника'],
        ['name' => 'MacBook Air M3', 'description' => 'Ультрабук Apple на чипе M3, 13 дюймов, 16 ГБ RAM', 'price' => 149990, 'image' => 'https://cdn.dummyjson.com/products/images/laptops/Apple%20MacBook%20Pro%2014%20Inch%20Space%20Grey/1.png', 'category' => 'Электроника'],
        ['name' => 'AirPods Pro 2', 'description' => 'Беспроводные наушники с активным шумоподавлением', 'price' => 24990, 'image' => 'https://static.re-store.ru/upload/resize_cache/iblock/54e/100500_800_140cd750bba9870f18aada2478b24840a/uxhp1ei5e9h56ufud1jbg00m2p661tdh.jpg', 'category' => 'Электроника'],
        
        // Одежда (4 товара)
        ['name' => 'Джинсы Levi\'s 501', 'description' => 'Классические прямые джинсы, 100% хлопок', 'price' => 8990, 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1wjBAgZPjmt-rhDcuWDQTQTBfsINBxFhGHA&s', 'category' => 'Одежда'],
        ['name' => 'Куртка Columbia', 'description' => 'Зимняя утеплённая куртка с водоотталкивающей пропиткой', 'price' => 15990, 'image' => 'https://main-cdn.sbermegamarket.ru/big1/hlr-system/151473986/100025058816b0.jpg', 'category' => 'Одежда'],
        ['name' => 'Кроссовки Nike Air Max', 'description' => 'Спортивные кроссовки с амортизацией Air', 'price' => 12990, 'image' => 'https://cdn.dummyjson.com/products/images/mens-shoes/Nike%20Air%20Jordan%201%20Red%20And%20Black/1.png', 'category' => 'Одежда'],
        ['name' => 'Футболка Adidas', 'description' => 'Спортивная футболка из дышащей ткани', 'price' => 2490, 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkJ45OrPtKqyeTQr2SQaBSTq449Zuz2TlTvQ&s', 'category' => 'Одежда'],
        
        // Дом и сад (4 товара)
        ['name' => 'Диван угловой', 'description' => 'Современный угловой диван с ортопедическим матрасом', 'price' => 54990, 'image' => 'https://www.restmebel.ru/upload/iblock/00d/00dc9479887d5aa5e18010277c098001.jpg', 'category' => 'Дом и сад'],
        ['name' => 'Кресло офисное', 'description' => 'Эргономичное кресло с поясничной поддержкой', 'price' => 18990, 'image' => 'https://mirmebeli68.ru/wp-content/uploads/2021/06/chairman_503_1.jpg', 'category' => 'Дом и сад'],
        ['name' => 'Настольная лампа', 'description' => 'LED-лампа с регулировкой яркости и температуры света', 'price' => 3490, 'image' => 'https://images.firma-gamma.ru/images/d/a/d15561120732l.jpg', 'category' => 'Дом и сад'],
        ['name' => 'Набор посуды', 'description' => 'Набор кастрюль и сковородок с антипригарным покрытием', 'price' => 9990, 'image' => 'https://posudacenter.ru/upload/resize_cache/iblock/2c0/630_630_1821712164bebe8964a3cb4f91f48bb72/2c0c2a5fadcf4611c5e1c667508a247f.jpg', 'category' => 'Дом и сад'],
        
        // Спорт (4 товара)
        ['name' => 'Велосипед горный', 'description' => 'Горный велосипед 29", алюминиевая рама, 21 скорость', 'price' => 45990, 'image' => 'https://cdn.velostrana.ru/upload/models/velo/66189/full.jpg', 'category' => 'Спорт'],
        ['name' => 'Гантели разборные', 'description' => 'Набор разборных гантелей от 2 до 20 кг', 'price' => 7990, 'image' => 'https://sportlim.ru/upload/resize_cache/iblock/f27/400_400_140cd750bba9870f18aada2478b24840a/dtkzj1t3ei0i348tke2kveqhth6vms88.png', 'category' => 'Спорт'],
        ['name' => 'Коврик для йоги', 'description' => 'Нескользящий коврик из TPE, 183x61 см', 'price' => 1990, 'image' => 'https://basket-02.wbbasket.ru/vol152/part15295/15295147/images/big/1.webp', 'category' => 'Спорт'],
        ['name' => 'Фитнес-браслет Xiaomi', 'description' => 'Трекер активности с пульсометром и мониторингом сна', 'price' => 3990, 'image' => 'https://static.ru-mi.com/upload/resize_cache/iblock/2a6/440_440_1/ateyvommr10knyvajunldq3jr5k4cutb.jpeg', 'category' => 'Спорт'],
        
        // Книги (4 товара)
        ['name' => 'Мастер и Маргарита', 'description' => 'М.А. Булгаков, классика русской литературы, твёрдый переплёт', 'price' => 890, 'image' => 'https://imo10.labirint.ru/books/668307/cover.jpg/242-0', 'category' => 'Книги'],
        ['name' => 'Гарри Поттер. Полное собрание', 'description' => 'Дж.К. Роулинг, все 7 книг в подарочном издании', 'price' => 5990, 'image' => 'https://ir.ozone.ru/multimedia/c1000/1013750772.jpg', 'category' => 'Книги'],
        ['name' => 'Python для начинающих', 'description' => 'Учебник по программированию на Python 3', 'price' => 1490, 'image' => 'https://ir.ozone.ru/s3/multimedia-m/c1000/6621104650.jpg', 'category' => 'Книги'],
        ['name' => 'Атлас мира', 'description' => 'Географический атлас с картами всех стран', 'price' => 2990, 'image' => 'https://cdn.litres.ru/pub/c/cover_415/71227264.jpg', 'category' => 'Книги'],
        
        // Красота (4 товара)
        ['name' => 'Духи Chanel No.5', 'description' => 'Классический женский аромат, 100 мл', 'price' => 12990, 'image' => 'https://cdn.dummyjson.com/products/images/fragrances/Chanel%20Coco%20Noir%20Eau%20De/1.png', 'category' => 'Красота'],
        ['name' => 'Крем для лица La Roche', 'description' => 'Увлажняющий крем для чувствительной кожи, 50 мл', 'price' => 1890, 'image' => 'https://images.apteka.ru/original_2e45f5c6-1375-4bec-a18b-379e0c705ac8.jpeg', 'category' => 'Красота'],
        ['name' => 'Набор кистей для макияжа', 'description' => 'Профессиональный набор из 12 кистей', 'price' => 2490, 'image' => 'https://pcdn.goldapple.ru/p/p/19000159540/web/696d674d61696e5064708ddc58d1d6e1dee.jpg', 'category' => 'Красота'],
        ['name' => 'Лак для ногтей OPI', 'description' => 'Стойкий лак, широкая палитра цветов', 'price' => 890, 'image' => 'https://pcdn.goldapple.ru/p/p/3123100104/web/696d674d61696e5064708ddc434e5e19ba1.jpg', 'category' => 'Красота'],
    ];

    private static $index = 0;

    public function definition()
    {
        if (self::$index >= count(self::$products)) {
            self::$index = 0;
        }
        
        $product = self::$products[self::$index];
        self::$index++;
        
        // Находим категорию по названию
        $categoryName = $product['category'];
        $category = Category::where('name', $categoryName)->first();
        
        $product['category_id'] = $category ? $category->id : Category::factory();
        unset($product['category']); // Убираем временное поле
        
        return $product;
    }
}
