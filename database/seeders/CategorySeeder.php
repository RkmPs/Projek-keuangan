<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Categories;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $incomeCategories = ['Salary', 'Bonus', 'Freelance', 'Deposito', 'Royalti', 'Uang Kaget'];
        $expenseCategories = ['Rent', 'Food', 'Transport', 'Utilities', 'Entertainment'];

        foreach ($users as $user) {
            foreach ($incomeCategories as $category) {
                Categories::create([
                    'user_id' => $user->id,
                    'name' => $category,
                    'type' => 'Income',
                ]);
            }

            foreach ($expenseCategories as $category) {
                Categories::create([
                    'user_id' => $user->id,
                    'name' => $category,
                    'type' => 'Expense',
                ]);
            }
        }
    }
}
