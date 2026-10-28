<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ReportUpdate extends Model {protected $fillable=['report_id','user_id','status','note','planned_date'];protected function casts():array{return ['planned_date'=>'date'];}public function user(){return $this->belongsTo(User::class);} }
