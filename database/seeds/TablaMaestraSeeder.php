<?php

use App\Models\TablaMaestra;
use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;

class TablaMaestraSeeder extends CsvSeeder
{
	public function __construct(){
        $this->file = '/database/seeds/csvs/tabla_maestras.csv';
        $this->encode=false;
    }

    public function run()
    {
        DB::disableQueryLog();
	    parent::run();
    }
}
