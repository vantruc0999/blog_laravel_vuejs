<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = [
            'Chính trị',
            'Kinh tế',
            'Xã hội',
            'Thế giới',
            'Văn hóa',
            'Thể thao',
            'Giáo dục',
            'Sức khỏe',
            'Khoa học',
            'Công nghệ',
            'Pháp luật',
            'Giao thông',
            'Du lịch',
            'Ẩm thực',
            'Âm nhạc',
            'Sách báo',
            'Thời trang',
            'Làm đẹp',
            'Kinh doanh',
            'Startup',
        ];
        
        // You can use this $categories array for your needs in a Laravel project.
        $categoryName = $categories[array_rand($categories)];
        return [
            //
            'name' =>  $categoryName,
            'rules' => fake()->text,
        ];
    }
}
