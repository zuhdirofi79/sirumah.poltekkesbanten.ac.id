<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
 use Notifiable;
 protected $fillable=['name','email','password','role','department','student_number','is_active','email_verified_at'];
 protected $hidden=['password','remember_token'];
 protected function casts():array {return ['password'=>'hashed','is_active'=>'boolean','email_verified_at'=>'datetime'];}
 public function isStaff():bool{return in_array($this->role,['admin','verifier','superadmin'],true);}
 public function isSuper():bool{return $this->role==='superadmin';}
}
