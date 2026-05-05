<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\KategoriSeeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
        ]);
    }
}
//
// Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum nisi vel turpis interdum egestas. Sed ac orci porta, elementum felis sed, commodo ipsum. Donec fermentum, odio ut sodales ullamcorper, nisi purus convallis ante, malesuada aliquet metus enim id nunc. In eget facilisis nulla, vel elementum odio. Nunc pulvinar enim non nulla convallis eleifend. Integer finibus massa et dictum convallis. Vivamus feugiat sit amet ex nec molestie. Phasellus pellentesque arcu neque, in rutrum velit vehicula vitae. Proin sed ipsum et metus convallis placerat. Donec accumsan dictum lectus, ut bibendum nibh auctor ac. Praesent nec erat vitae lorem egestas ultricies in at ipsum. Mauris ac erat eu urna molestie tempus vitae quis justo. 