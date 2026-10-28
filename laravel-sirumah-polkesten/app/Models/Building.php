<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Building extends Model { protected $fillable=['location_id','name','active']; public function floors(){return $this->hasMany(Floor::class);} public function location(){return $this->belongsTo(Location::class);} }
