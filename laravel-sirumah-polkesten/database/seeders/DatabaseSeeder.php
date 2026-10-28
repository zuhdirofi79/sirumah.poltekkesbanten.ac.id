<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Location,Building,Floor};
class DatabaseSeeder extends Seeder {
 public function run():void {
  foreach(['Asrama Tangerang'=>['buildings'=>['Gedung A','Gedung B','Gedung C','Gedung D','Gedung E'],'floors'=>['Lantai 1']], 'Asrama Serang'=>['buildings'=>['Gedung A'],'floors'=>['Lantai 1','Lantai 2','Lantai 3']], 'Asrama Rangkasbitung'=>['buildings'=>['Gedung A','Gedung B','Gedung C','Gedung D'],'floors'=>['Lantai 1']]] as $name=>$v){
   $l=Location::firstOrCreate(['name'=>$name]);foreach($v['buildings'] as $b){$building=Building::firstOrCreate(['location_id'=>$l->id,'name'=>$b]);foreach($v['floors'] as $floor)Floor::firstOrCreate(['building_id'=>$building->id,'name'=>$floor]);}
  }
 }
}
