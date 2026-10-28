<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model {
 protected $fillable=['ticket','user_id','location_id','building_id','floor_id','room_id','category','title','description','status','planned_date','assigned_to'];
 protected function casts():array{return ['planned_date'=>'date'];}
 public function user(){return $this->belongsTo(User::class);}
 public function location(){return $this->belongsTo(Location::class);}
 public function building(){return $this->belongsTo(Building::class);}
 public function floor(){return $this->belongsTo(Floor::class);}
 public function room(){return $this->belongsTo(Room::class);}
 public function updates(){return $this->hasMany(ReportUpdate::class)->orderBy('created_at');}
 public function attachments(){return $this->hasMany(Attachment::class);}
}
