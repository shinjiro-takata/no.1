<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;
    protected static $jaFaker;

    public function definition()
    {
        if (!self::$jaFaker) {
            self::$jaFaker = \Faker\Factory::create('ja_JP');
        }

        $categoryId = Category::query()->inRandomOrder()->value('id');

        if ($categoryId === null) {
            $categoryId = Category::query()->create([
                'content' => 'その他',
            ])->id;
        }

        $timestamp = $this->faker->dateTimeBetween('-30 days', 'now');

        return [
            'category_id' => $categoryId,
            'first_name' => self::$jaFaker->firstName(),
            'last_name' => self::$jaFaker->lastName(),
            'gender' => $this->faker->randomElement(array_keys(Contact::GENDER_LABELS)),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->numerify('0#-####-####'),
            'address' => self::$jaFaker->address(),
            'building' => $this->faker->optional(0.5)->randomElement([
                '青山マンション101',
                '桜ハイツ203',
                'コーポひまわり305',
                'グリーンビル5F',
                'リバーサイドタワー1202',
            ]),
            'detail' => self::$jaFaker->realText(100),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }
}
