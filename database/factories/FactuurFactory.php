<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Factuur;
use App\Models\Customer;
use App\Models\Product;

class FactuurFactory extends Factory
{
    protected $model = Factuur::class;

    public function definition(): array
    {
        // Generate dates weighted toward the past (most invoices should be before today)
        // 80% past invoices (2020 to now), 20% future invoices (now to 2030)
        $now = new \DateTime();
        if ($this->faker->boolean(80)) {
            // Past invoice
            $invoiceDate = $this->faker->dateTimeBetween('2020-01-01', 'now');
        } else {
            // Future invoice
            $invoiceDate = $this->faker->dateTimeBetween('now', '2030-12-31');
        }
        
        $paymentTermsDays = $this->faker->randomElement([7, 14, 30]);
        $dueDate = (clone $invoiceDate)->modify("+{$paymentTermsDays} days");

        $isPastDue = $dueDate < $now;
        $isPastInvoice = $invoiceDate < $now;
        
        // For past invoices, heavily favor paid status (70% paid)
        if ($isPastInvoice) {
            if ($isPastDue) {
                // Past due date - 70% paid, 20% verlopen, 10% verzonden
                $statuses = ['betaald', 'betaald', 'betaald', 'betaald', 'betaald', 'betaald', 'betaald', 'verlopen', 'verlopen', 'verzonden'];
            } else {
                // Due date not passed yet - 60% paid, 30% verzonden, 10% concept
                $statuses = ['betaald', 'betaald', 'betaald', 'betaald', 'betaald', 'betaald', 'verzonden', 'verzonden', 'verzonden', 'concept'];
            }
        } else {
            // Future invoices
            $statuses = ['concept', 'concept', 'verzonden'];
        }
        $status = $this->faker->randomElement($statuses);

        // Calculate paid_at based on status
        $paidAt = null;
        if ($status === 'betaald') {
            $maxPayDate = $isPastDue ? (clone $dueDate)->modify('+30 days') : $dueDate;
            // Make sure max pay date is not in the future
            if ($maxPayDate > $now) {
                $maxPayDate = $now;
            }
            $paidAt = $this->faker->dateTimeBetween($invoiceDate, $maxPayDate);
        }

        return [
            'name_company_id' => Customer::inRandomOrder()->first()?->id,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'reference' => $this->faker->optional(0.6)->randomElement([
                'CONTRACT-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 50), 3, '0', STR_PAD_LEFT),
                'OFF-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 50), 3, '0', STR_PAD_LEFT),
                'PROJECT-' . $this->faker->numberBetween(1000, 9999),
            ]),
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'ideal', 'creditcard', 'cash']),
            'description' => $this->faker->optional(0.7)->sentence(8),
            'notes' => $this->faker->optional(0.4)->sentence(12),
            'status' => $status,
            'sent_at' => in_array($status, ['verzonden', 'betaald', 'verlopen']) ? $invoiceDate : null,
            'paid_at' => $paidAt,
            'created_at' => $invoiceDate,
        ];
    }
}
