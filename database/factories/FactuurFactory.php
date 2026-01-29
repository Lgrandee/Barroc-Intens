<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Factuur;
use App\Models\Customer;

class FactuurFactory extends Factory
{
    protected $model = Factuur::class;

    public function definition(): array
    {
        $now = new \DateTime();
        
        // Weight towards realistic time periods - most invoices in recent years
        // 60% last 2 years, 30% 2-4 years ago, 10% older
        $rand = $this->faker->numberBetween(1, 100);
        if ($rand <= 60) {
            // Last 2 years (most activity)
            $invoiceDate = $this->faker->dateTimeBetween('-2 years', 'now');
        } elseif ($rand <= 90) {
            // 2-4 years ago
            $invoiceDate = $this->faker->dateTimeBetween('-4 years', '-2 years');
        } else {
            // Older history (2020-2022)
            $invoiceDate = $this->faker->dateTimeBetween('2020-01-01', '-4 years');
        }
        
        // B2B payment terms are typically 14-30 days
        $paymentTermsDays = $this->faker->randomElement([14, 30, 30, 30]); // 30 days is most common
        $dueDate = (clone $invoiceDate)->modify("+{$paymentTermsDays} days");

        $isPastDue = $dueDate < $now;
        $isPastInvoice = $invoiceDate < $now;
        
        // Realistic B2B payment behavior
        if ($isPastInvoice) {
            if ($isPastDue) {
                // Past due - 80% paid (B2B usually pays), 15% verlopen (overdue reminders), 5% still verzonden
                $statuses = array_merge(
                    array_fill(0, 80, 'betaald'),
                    array_fill(0, 15, 'verlopen'),
                    array_fill(0, 5, 'verzonden')
                );
            } else {
                // Recent, not yet due - 40% already paid (early payers), 50% verzonden, 10% concept
                $statuses = array_merge(
                    array_fill(0, 40, 'betaald'),
                    array_fill(0, 50, 'verzonden'),
                    array_fill(0, 10, 'concept')
                );
            }
        } else {
            // Future invoices (shouldn't exist normally, but for testing)
            $statuses = ['concept', 'concept', 'verzonden'];
        }
        $status = $this->faker->randomElement($statuses);

        // Calculate paid_at based on status
        $paidAt = null;
        if ($status === 'betaald') {
            $maxPayDate = $isPastDue ? (clone $dueDate)->modify('+14 days') : $dueDate;
            if ($maxPayDate > $now) {
                $maxPayDate = $now;
            }
            // Most B2B payments are around the due date
            $minPayDate = (clone $invoiceDate)->modify('+7 days');
            if ($minPayDate > $maxPayDate) {
                $minPayDate = $invoiceDate;
            }
            $paidAt = $this->faker->dateTimeBetween($minPayDate, $maxPayDate);
        }

        // Coffee business reference types
        $referenceTypes = [
            'MO-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 999), 4, '0', STR_PAD_LEFT), // Machine Order
            'BO-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 999), 4, '0', STR_PAD_LEFT), // Beans Order
            'SVC-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 999), 4, '0', STR_PAD_LEFT), // Service
            'MAINT-' . str_pad($this->faker->numberBetween(1000, 9999), 4, '0', STR_PAD_LEFT), // Maintenance contract
            'OFF-' . $invoiceDate->format('Y') . '-' . str_pad($this->faker->numberBetween(1, 200), 3, '0', STR_PAD_LEFT), // From offerte
        ];

        // Coffee business invoice descriptions
        $descriptions = [
            'Levering koffiebonen - maandelijkse bestelling',
            'Installatie koffiesysteem nieuw',
            'Onderhoudsbeurt Q' . ceil($invoiceDate->format('n') / 3) . ' ' . $invoiceDate->format('Y'),
            'Reparatie espressomachine',
            'Levering onderdelen en accessoires',
            'Service contract verlenging',
            'Koffieproeverij voor personeel',
            'Training barista vaardigheden',
            'Vervanging waterfilters en onderhoud',
            'Nieuwe koffiemachine met installatie',
            null, // Some invoices without description
        ];

        return [
            'name_company_id' => Customer::inRandomOrder()->first()?->id,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'reference' => $this->faker->optional(0.85)->randomElement($referenceTypes),
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'bank_transfer', 'bank_transfer', 'ideal', 'creditcard']), // B2B mostly bank transfer
            'description' => $this->faker->randomElement($descriptions),
            'notes' => $this->faker->optional(0.3)->randomElement([
                'Factuur verzonden per post en email',
                'Klant verzocht om uitstel betaling - goedgekeurd',
                'Spoedlevering - extra kosten toegepast',
                'Onderdeel van jaarcontract',
                'Nieuwe klant - eerste bestelling',
                null,
            ]),
            'status' => $status,
            'sent_at' => in_array($status, ['verzonden', 'betaald', 'verlopen']) ? $invoiceDate : null,
            'paid_at' => $paidAt,
            'created_at' => $invoiceDate,
        ];
    }
}
