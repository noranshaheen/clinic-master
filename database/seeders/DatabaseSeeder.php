<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\ETA\Address;
use App\Models\ETA\Delivery;
use App\Models\ETA\Discount;
use App\Models\ETA\InvoiceLine;
use App\Models\ETA\Invoice;
use App\Models\ETA\Issuer;
use App\Models\General\Payment;
use App\Models\ETA\Receiver;
use App\Models\ETA\TaxableItem;
use App\Models\ETA\TaxTotal;
use App\Models\User;
use App\Models\Team;
use App\Models\ETA\Value;
use App\Models\General\Settings;
use App\Models\Reseptionist;
use App\Models\Specialty;


class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$item = new Team(["name" => "Reseptionist",   "personal_team" => 0,'user_id'=>1]);
		$item->save();
		$item = new Team(["name" => "Doctor",   "personal_team" => 0, 'user_id' => null]);
		$item->save();

		$item2 = new Reseptionist();
		$item2->name = 'Reseptionist';
		$item2->gender = 'M';
		$item2->date_of_birth = '2000-01-01';
		$item2->phone = '01012345678';
		$item2->save();

		$item1 = new User();
		$item1->name = "Reseptionist";
		$item1->email = "admin@clinicmaster.com";
		$item1->password = Hash::make("123456789");
		$item1->current_team_id = 1;
		$item1->doc_res_id = 1;
		$item1->save();



		$item = new Settings(["name" => "footer", "type" => "invoice settings", "value" => ""]);
		$item->save();
		$item = new Settings(["name" => "showQR", "type" => "invoice settings", "value" => "0"]);
		$item->save();


		//get data from file
		$sp_file = file_get_contents(public_path() . '/json/Specialties.json');
		$all_sp = json_decode($sp_file);
		foreach ($all_sp as $spl) {
			$specialty = new Specialty();
			$specialty->id = $spl->id;
			$specialty->name = $spl->name;
			$specialty->save();
		}
	}
}
