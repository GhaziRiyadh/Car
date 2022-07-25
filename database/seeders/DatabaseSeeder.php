<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\Car;
use App\Models\Classes;
use App\Models\Company;
use App\Models\Level;
use App\Models\LevelStudent;
use App\Models\LevelTeacher;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::query()->updateOrCreate(['id' => 1], [
            'name' => 'root',
            'password' => '123456789',
            'email' => 'root@gmail.com',
            'remember_token' => Str::random(10),
        ]);


        $admin = Role::create(['name' => 'admin', 'display_name' => 'admin']);
        $adminUser->attachRole($admin);

        $seller = Role::create(['name' => 'customer', 'display_name' => 'زبون']);
        // $seller = Role::create(['name' => 'seller', 'display_name' => 'تاجر']);

        $read = Permission::create(['name' => 'read']);
        $write = Permission::create(['name' => 'write']);
        $edit = Permission::create(['name' => 'edit']);

        $admin->attachPermissions([$read, $write, $edit]);

        $billStatus = ['متابعة الدفع', 'جاري تأكيد الدفع', 'تم الدفع', 'جاري تحضير الطلب', 'قيد التوصيل', 'تم التوصيل'];
        foreach ($billStatus as $status)
            BillStatus::create(['name' => $status]);

        User::factory(100)->create();
        Bill::factory(100)->create();
        Company::factory(3)->has(Car::factory(10)->hasProducts(10))->create();


        foreach (Product::all() as $product) {
            $product->image()->create([
                'path' => 'logo.jpg',
            ]);
        }

        foreach (User::all() as $user) {
            $user->image()->create([
                'path' => 'logo.jpg',
            ]);
        }

        foreach (Bill::all() as $bill) {
            $number = rand(1, 15);
            $total = 0;
            for ($i = 1; $i < $number; $i++) {
                $product = Product::find(rand(1, Product::count()));
                $product->bills()->attach($bill);
                $total += intval($product->price);
            }
            $bill->update(['total' => $total]);
        }

        foreach (User::all() as $key) {
            $key->attachRole($seller);
        }
    }
}
