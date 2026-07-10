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
            'Higher NoteBook',
            '2A NoteBook',
            '2B NoteBook',
            '2D NoteBook',
            'Drawing Book',
            '20 Leaves NoteBook',
            '40 Leaves NoteBook',
            '60 Leaves NoteBook',
            '80 Leaves NoteBook',
            'Small Invoice',
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