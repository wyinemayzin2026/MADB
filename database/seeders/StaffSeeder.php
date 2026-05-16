<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // အမည်များစာရင်း
        $staffNames = [
            1 => 'ဦးအောင်',
            2 => 'ဒေါ်နွယ်',
            3 => 'ဒေါ်ဝေ',
            4 => 'ဒေါ်ဝါ',
            5 => 'ထွန်း',
            6 => 'ဦးကျော်',
            7 => 'ဒေါ်ဖြူဖြူမြင့်',
            8 => 'ဒေါ်စုလှိုင်',
            9 => 'ဦးဇော်လွင်',
            10 => 'ဒေါ်မြတ်',
            11 => 'ဦးဘ',
            12 => 'ဒေါ်ဖြိုး',
        ];

        foreach ($staffNames as $index => $name) {
            Staff::create([
                'eid' => 1000 + $index,
                'name' => $name,
                'nrc' => $this->generateNRC($index), // NRC အသစ်ထည့်သွင်းခြင်း
                'address' => 'MADB ရုံးဝင်းအတွင်း',
                'phone' => '091234567' . $index,
                'email' => 'staff' . $index . '@ird.gov.mm',
                'position' => $this->getPosition($index),
                'role' => ($index === 1) ? 'admin' : 'staff',
                'password' => Hash::make('password123'),
            ]);
        }
    }

    /**
     * NRC နံပါတ်များကို ကျပန်းထုတ်ပေးရန်
     */
    private function generateNRC($index)
    {
        $states = ['၁၂/', '၉/', '၅/', '၇/'];
        $townships = ['ဗတလ(နိုင်)', 'မရက(နိုင်)', 'ရကန(နိုင်)', 'တကန(နိုင်)'];

        $state = $states[$index % count($states)];
        $township = $townships[$index % count($townships)];
        $number = str_pad(100000 + $index, 6, '0', STR_PAD_LEFT);

        return $state . $township . $number;
    }

    /**
     * ရာထူးများကို ခွဲခြားပေးရန်
     */
    private function getPosition($index)
    {
        $positions = ['ဦးစီးအရာရှိ', 'ဒု-ဦးစီးမှူး', 'စာရေးကြီး', 'အကြီးတန်းစာရေး'];
        return $positions[$index % count($positions)];
    }
}
