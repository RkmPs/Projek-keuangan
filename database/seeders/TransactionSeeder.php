<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use Faker\Factory;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $users = User::all();

        foreach ($users as $user) {
            $accountInfo = $user->accountInfo;
            $categories = $user->categories;
            $balanceChange = 0;

            for ($i = 0; $i < 20; $i++) {
                $category = $categories->random();
                $amount = $faker->numberBetween(1000, 100000);
                $type = $category->type;

                Transaction::create([
                    'user_id' => $user->id,
                    'categories_id' => $category->id,
                    'amount' => $amount,
                    'type' => $type,
                    'description' => $faker->sentence(),
                ]);

                $balanceChange += ($type === 'Income') ? $amount : -$amount;
            }

            $accountInfo->balance += $balanceChange;
            $accountInfo->save();
        }
    }
}
