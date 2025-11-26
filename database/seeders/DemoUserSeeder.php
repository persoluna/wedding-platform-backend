<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo users already exist
        if (User::where('email', 'admin@shaadimandap.com')->exists()) {
            $this->command->info('⏭ Demo users already seeded, skipping...');
            return;
        }

        // ═══════════════════════════════════════════════════════════════════
        // ADMIN USERS
        // ═══════════════════════════════════════════════════════════════════

        $admins = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'admin@shaadimandap.com',
                'phone' => '+91 98765 43210',
                'type' => 'admin',
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@shaadimandap.com',
                'phone' => '+91 98765 43211',
                'type' => 'admin',
            ],
        ];

        foreach ($admins as $admin) {
            $user = User::create([
                ...$admin,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
            $user->assignRole('super_admin');
        }

        // ═══════════════════════════════════════════════════════════════════
        // AGENCY OWNER USERS
        // ═══════════════════════════════════════════════════════════════════

        $agencyOwners = [
            [
                'name' => 'Vikram Malhotra',
                'email' => 'vikram@dreamshaadi.in',
                'phone' => '+91 98111 22333',
                'type' => 'agency',
            ],
            [
                'name' => 'Sunita Reddy',
                'email' => 'sunita@weddingwala.com',
                'phone' => '+91 98222 33444',
                'type' => 'agency',
            ],
            [
                'name' => 'Arun Kapoor',
                'email' => 'arun@royalweddings.in',
                'phone' => '+91 98333 44555',
                'type' => 'agency',
            ],
            [
                'name' => 'Meera Patel',
                'email' => 'meera@bandbaajaa.com',
                'phone' => '+91 98444 55666',
                'type' => 'agency',
            ],
            [
                'name' => 'Deepak Singhania',
                'email' => 'deepak@shubhvivah.com',
                'phone' => '+91 98555 66777',
                'type' => 'agency',
            ],
            [
                'name' => 'Kavita Menon',
                'email' => 'kavita@southernweddings.in',
                'phone' => '+91 98666 77888',
                'type' => 'agency',
            ],
            [
                'name' => 'Rohit Gupta',
                'email' => 'rohit@destinationido.com',
                'phone' => '+91 98777 88999',
                'type' => 'agency',
            ],
            [
                'name' => 'Ananya Iyer',
                'email' => 'ananya@eleganceweddings.in',
                'phone' => '+91 98888 99000',
                'type' => 'agency',
            ],
        ];

        foreach ($agencyOwners as $owner) {
            $user = User::create([
                ...$owner,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
            $user->assignRole('agency');
        }

        // ═══════════════════════════════════════════════════════════════════
        // VENDOR USERS
        // ═══════════════════════════════════════════════════════════════════

        $vendorUsers = [
            // Photographers
            ['name' => 'Arjun Nair', 'email' => 'arjun@pixelperfect.in', 'phone' => '+91 99001 11222', 'type' => 'vendor'],
            ['name' => 'Neha Verma', 'email' => 'neha@candiddreams.com', 'phone' => '+91 99002 22333', 'type' => 'vendor'],
            ['name' => 'Siddharth Joshi', 'email' => 'sid@storiesbysi.com', 'phone' => '+91 99003 33444', 'type' => 'vendor'],
            ['name' => 'Ritu Saxena', 'email' => 'ritu@clicksbyrit.in', 'phone' => '+91 99004 44555', 'type' => 'vendor'],
            ['name' => 'Karan Bhatia', 'email' => 'karan@filmsandframes.com', 'phone' => '+91 99005 55666', 'type' => 'vendor'],

            // Caterers
            ['name' => 'Ramesh Agarwal', 'email' => 'ramesh@royalcaterers.in', 'phone' => '+91 99101 11222', 'type' => 'vendor'],
            ['name' => 'Lakshmi Naidu', 'email' => 'lakshmi@swaadcatering.com', 'phone' => '+91 99102 22333', 'type' => 'vendor'],
            ['name' => 'Mohammad Khan', 'email' => 'khan@mughalcuisine.in', 'phone' => '+91 99103 33444', 'type' => 'vendor'],
            ['name' => 'Gurpreet Singh', 'email' => 'gurpreet@punjabiswag.com', 'phone' => '+91 99104 44555', 'type' => 'vendor'],

            // Decorators
            ['name' => 'Pooja Mehta', 'email' => 'pooja@floralaffairs.in', 'phone' => '+91 99201 11222', 'type' => 'vendor'],
            ['name' => 'Rakesh Bansal', 'email' => 'rakesh@royaldecor.com', 'phone' => '+91 99202 22333', 'type' => 'vendor'],
            ['name' => 'Shreya Das', 'email' => 'shreya@bloomnpetals.in', 'phone' => '+91 99203 33444', 'type' => 'vendor'],

            // Makeup Artists
            ['name' => 'Simran Kaur', 'email' => 'simran@bridalbysim.com', 'phone' => '+91 99301 11222', 'type' => 'vendor'],
            ['name' => 'Anjali Deshmukh', 'email' => 'anjali@glamourstudio.in', 'phone' => '+91 99302 22333', 'type' => 'vendor'],
            ['name' => 'Fatima Sheikh', 'email' => 'fatima@beautybyfatima.com', 'phone' => '+91 99303 33444', 'type' => 'vendor'],

            // DJs & Entertainment
            ['name' => 'DJ Rahul', 'email' => 'rahul@djrahulofficial.com', 'phone' => '+91 99401 11222', 'type' => 'vendor'],
            ['name' => 'Vishal Sharma', 'email' => 'vishal@soundwavesdj.in', 'phone' => '+91 99402 22333', 'type' => 'vendor'],
            ['name' => 'Amit Trivedi', 'email' => 'amit@rhythmband.com', 'phone' => '+91 99403 33444', 'type' => 'vendor'],

            // Venues
            ['name' => 'Suresh Rathore', 'email' => 'suresh@palaceresort.in', 'phone' => '+91 99501 11222', 'type' => 'vendor'],
            ['name' => 'Prakash Jain', 'email' => 'prakash@grandballroom.com', 'phone' => '+91 99502 22333', 'type' => 'vendor'],
            ['name' => 'Harish Shetty', 'email' => 'harish@beachsideresort.in', 'phone' => '+91 99503 33444', 'type' => 'vendor'],

            // Mehndi Artists
            ['name' => 'Sarita Choudhary', 'email' => 'sarita@mehndibysarita.com', 'phone' => '+91 99601 11222', 'type' => 'vendor'],
            ['name' => 'Rekha Bai', 'email' => 'rekha@heenaartistry.in', 'phone' => '+91 99602 22333', 'type' => 'vendor'],

            // Choreographers
            ['name' => 'Shiamak Jr', 'email' => 'jr@dancewithjr.com', 'phone' => '+91 99701 11222', 'type' => 'vendor'],
            ['name' => 'Parul Arora', 'email' => 'parul@sangeetbypaul.in', 'phone' => '+91 99702 22333', 'type' => 'vendor'],

            // Invitation Card Designers
            ['name' => 'Kunal Ahuja', 'email' => 'kunal@cardsbykun.com', 'phone' => '+91 99801 11222', 'type' => 'vendor'],
            ['name' => 'Nisha Sharma', 'email' => 'nisha@designernisha.in', 'phone' => '+91 99802 22333', 'type' => 'vendor'],

            // Transportation
            ['name' => 'Rajiv Chadha', 'email' => 'rajiv@luxurycars.in', 'phone' => '+91 99901 11222', 'type' => 'vendor'],
            ['name' => 'Sanjay Mehta', 'email' => 'sanjay@vintagewheels.com', 'phone' => '+91 99902 22333', 'type' => 'vendor'],

            // Pandits
            ['name' => 'Pt. Ramakrishna Shastri', 'email' => 'shastri@vedicweddings.in', 'phone' => '+91 99911 11222', 'type' => 'vendor'],
            ['name' => 'Pt. Suresh Pandey', 'email' => 'pandey@shaadipandit.com', 'phone' => '+91 99912 22333', 'type' => 'vendor'],
        ];

        foreach ($vendorUsers as $vendor) {
            $user = User::create([
                ...$vendor,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
            $user->assignRole('vendor');
        }

        // ═══════════════════════════════════════════════════════════════════
        // CLIENT USERS (Couples planning weddings)
        // ═══════════════════════════════════════════════════════════════════

        $clientUsers = [
            ['name' => 'Aarav Gupta', 'email' => 'aarav.gupta@gmail.com', 'phone' => '+91 88001 11222', 'type' => 'client'],
            ['name' => 'Ishita Sharma', 'email' => 'ishita.sharma@gmail.com', 'phone' => '+91 88002 22333', 'type' => 'client'],
            ['name' => 'Rohan Malhotra', 'email' => 'rohan.m@yahoo.com', 'phone' => '+91 88003 33444', 'type' => 'client'],
            ['name' => 'Ananya Reddy', 'email' => 'ananya.reddy@gmail.com', 'phone' => '+91 88004 44555', 'type' => 'client'],
            ['name' => 'Vivaan Patel', 'email' => 'vivaan.p@outlook.com', 'phone' => '+91 88005 55666', 'type' => 'client'],
            ['name' => 'Diya Kapoor', 'email' => 'diya.kapoor@gmail.com', 'phone' => '+91 88006 66777', 'type' => 'client'],
            ['name' => 'Aditya Singh', 'email' => 'aditya.singh@gmail.com', 'phone' => '+91 88007 77888', 'type' => 'client'],
            ['name' => 'Priyanka Joshi', 'email' => 'priyanka.j@yahoo.com', 'phone' => '+91 88008 88999', 'type' => 'client'],
            ['name' => 'Aryan Verma', 'email' => 'aryan.verma@gmail.com', 'phone' => '+91 88009 99000', 'type' => 'client'],
            ['name' => 'Saanvi Iyer', 'email' => 'saanvi.iyer@gmail.com', 'phone' => '+91 88010 10111', 'type' => 'client'],
            ['name' => 'Kabir Khan', 'email' => 'kabir.khan@gmail.com', 'phone' => '+91 88011 11222', 'type' => 'client'],
            ['name' => 'Myra Saxena', 'email' => 'myra.s@outlook.com', 'phone' => '+91 88012 12333', 'type' => 'client'],
            ['name' => 'Reyansh Agarwal', 'email' => 'reyansh.a@gmail.com', 'phone' => '+91 88013 13444', 'type' => 'client'],
            ['name' => 'Kiara Menon', 'email' => 'kiara.menon@gmail.com', 'phone' => '+91 88014 14555', 'type' => 'client'],
            ['name' => 'Vihaan Nair', 'email' => 'vihaan.n@yahoo.com', 'phone' => '+91 88015 15666', 'type' => 'client'],
        ];

        foreach ($clientUsers as $client) {
            $user = User::create([
                ...$client,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
            $user->assignRole('client');
        }

        $this->command->info('✓ Created ' . User::count() . ' users (2 admins, 8 agency owners, 31 vendors, 15 clients) with roles assigned');
    }
}
