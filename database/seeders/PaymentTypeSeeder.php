<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentType::create([
            'payment_type_name' => 'Cash',
        ]);
        PaymentType::create([
            'payment_type_name' => 'Check',
        ]);
        $this->command->info('Payment type creaded!');
    }
}
