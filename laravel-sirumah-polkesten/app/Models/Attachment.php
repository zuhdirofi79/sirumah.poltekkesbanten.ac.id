<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Attachment extends Model {protected $fillable=['report_id','path','mime','original_name','size'];}
