<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the logged-in user's company_id from the session context
        $companyId = auth()->user()->company_id ?? null;

        // Fallback protection if no user is logged in (e.g., when running via terminal)
        if (!$companyId) {
            // Check if run via command line interface (CLI) to pull a default or throw an error
            if (app()->runningInConsole()) {
                $fallbackUser = DB::table('users')->whereNotNull('company_id')->first();
                $companyId = $fallbackUser ? $fallbackUser->company_id : null;
            }
        }

        if (!$companyId) {
            $this->command->error('Seeding aborted: Unable to determine the authenticated user\'s company_id.');
            return;
        }

        $products = [
            'Higher Note Book',
            '2A Note Book',
            '2B Note Book',
            '2D Note Book',
            'Drawing Book',
            '20 Leaves Note Book',
            '40 Leaves Note Book',
            '60 Leaves Note Book',
            '80 Leaves Note Book',
            'Small Invoice Templates',
            'Brochures',
            'Flyers',
            'Business Cards',
            'Envelopes',
            'Notepads',
            'Booklets',
            'Stickers',
            'Service Order'
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product);

            // Verify if the product already exists for this authenticated company
            $exists = DB::table('product_types')
                ->where('slug', $slug)
                ->where('company_id', $companyId)
                ->exists();

            if (!$exists) {
                DB::table('product_types')->insert([
                    'company_id' => $companyId,
                    'name'       => $product,
                    'slug'       => $slug,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}