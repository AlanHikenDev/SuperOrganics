<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Seed the leads and lead notes tables.
     */
    public function run(): void
    {
        // Create a default user if none exists
        $user = User::firstOrCreate(
            ['email' => 'sales@superorganics.com'],
            [
                'name' => 'Sales Rep',
                'password' => bcrypt('password'),
            ]
        );

        $leads = [
            [
                'name' => 'Maria Gonzalez',
                'company' => 'Green Earth Market',
                'email' => 'maria@greenearthmarket.com',
                'phone' => '+1 (555) 123-4567',
                'status' => 'contacted',
                'notes' => [
                    'Buyer wants to review wholesale pricing.',
                    'Follow up scheduled for next Tuesday regarding bulk organic produce.',
                    'Interested in our seasonal fruit box subscription.',
                ],
            ],
            [
                'name' => 'James Chen',
                'company' => 'Organic Valley Co.',
                'email' => 'j.chen@organicvalley.co',
                'phone' => '+1 (555) 234-5678',
                'status' => 'qualified',
                'notes' => [
                    'Decision maker confirmed — VP of Procurement.',
                    'Requested sample shipment of cold-pressed juices.',
                ],
            ],
            [
                'name' => 'Priya Patel',
                'company' => 'Fresh & Pure Foods',
                'email' => 'priya@freshpure.com',
                'phone' => '+1 (555) 345-6789',
                'status' => 'new',
                'notes' => [
                    'Inbound lead from trade show booth.',
                ],
            ],
            [
                'name' => 'David Muller',
                'company' => 'BioHarvest Distributors',
                'email' => 'dmuller@bioharvest.net',
                'phone' => '+1 (555) 456-7890',
                'status' => 'proposal',
                'notes' => [
                    'Sent proposal for Q3 partnership. Awaiting feedback.',
                    'Competitor pricing is $0.50/unit lower — may need to offer volume discount.',
                    'Board meeting on Friday will decide next steps.',
                    'Mentioned interest in private-label options.',
                ],
            ],
            [
                'name' => 'Sofia Reyes',
                'company' => 'Tierra Sana Market',
                'email' => 'sofia@tierrasana.mx',
                'phone' => '+52 (55) 7890-1234',
                'status' => 'contacted',
                'notes' => [
                    'Initial call went well. Interested in cross-border distribution.',
                ],
            ],
            [
                'name' => 'Robert Kim',
                'company' => 'Pacific Greens LLC',
                'email' => 'rkim@pacificgreens.com',
                'phone' => '+1 (555) 567-8901',
                'status' => 'new',
                'notes' => [],
            ],
        ];

        foreach ($leads as $leadData) {
            $notes = $leadData['notes'];
            unset($leadData['notes']);

            $lead = Lead::create($leadData);

            foreach ($notes as $index => $noteText) {
                LeadNote::create([
                    'lead_id' => $lead->id,
                    'user_id' => $user->id,
                    'note' => $noteText,
                    'created_at' => now()->subHours(count($notes) - $index),
                    'updated_at' => now()->subHours(count($notes) - $index),
                ]);
            }
        }
    }
}
