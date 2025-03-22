<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Faker\Factory;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = Factory::create();
    $users = User::all();

    // Tetapkan rentang waktu untuk seluruh tahun berjalan
    $currentYear = date('Y');
    $startDate = new \DateTimeImmutable("{$currentYear}-01-01");
    $endDate = new \DateTimeImmutable("{$currentYear}-12-31");

    foreach ($users as $user) {
        $accountInfo = $user->accountInfo;
        $categories = $user->categories;
        $balanceChange = 0;

        // Perbanyak transaksi menjadi 100 per user untuk distribusi bulanan yang lebih baik
        for ($i = 0; $i < 100; $i++) {
            $category = $categories->random();
            $amount = $faker->numberBetween(1000, 100000);
            $type = $category->type;
            
            // Generate tanggal acak dalam rentang 1 tahun
            $transactionDate = $faker->dateTimeBetween(
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            );

            Transaction::create([
                'user_id' => $user->id,
                'categories_id' => $category->id,
                'amount' => $amount,
                'type' => $type,
                'description' => $faker->sentence(),
                'created_at' => $transactionDate,
                'updated_at' => $transactionDate,
            ]);

            $balanceChange += ($type === 'Income') ? $amount : -$amount;
        }

        $accountInfo->balance += $balanceChange;
        $accountInfo->save();
    }
}
}
