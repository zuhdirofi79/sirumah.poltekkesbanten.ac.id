<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {
 Schema::create('users',function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->timestamp('email_verified_at')->nullable();$t->string('password');$t->enum('role',['student','admin','verifier','superadmin'])->default('student');$t->string('department')->nullable();$t->string('student_number')->nullable();$t->boolean('is_active')->default(true);$t->rememberToken();$t->timestamps();});
 Schema::create('password_reset_tokens',function(Blueprint $t){$t->string('email')->primary();$t->string('token');$t->timestamp('created_at')->nullable();});
 Schema::create('sessions',function(Blueprint $t){$t->string('id')->primary();$t->foreignId('user_id')->nullable()->index();$t->string('ip_address',45)->nullable();$t->text('user_agent')->nullable();$t->longText('payload');$t->integer('last_activity')->index();});
 Schema::create('locations',function(Blueprint $t){$t->id();$t->string('name')->unique();$t->boolean('active')->default(true);$t->timestamps();});
 Schema::create('buildings',function(Blueprint $t){$t->id();$t->foreignId('location_id')->constrained()->cascadeOnDelete();$t->string('name');$t->boolean('active')->default(true);$t->unique(['location_id','name']);$t->timestamps();});
 Schema::create('floors',function(Blueprint $t){$t->id();$t->foreignId('building_id')->constrained()->cascadeOnDelete();$t->string('name');$t->boolean('active')->default(true);$t->unique(['building_id','name']);$t->timestamps();});
 Schema::create('rooms',function(Blueprint $t){$t->id();$t->foreignId('floor_id')->constrained()->cascadeOnDelete();$t->string('name');$t->boolean('active')->default(true);$t->unique(['floor_id','name']);$t->timestamps();});
 Schema::create('reports',function(Blueprint $t){$t->id();$t->string('ticket')->unique();$t->foreignId('user_id')->constrained();$t->foreignId('location_id')->constrained();$t->foreignId('building_id')->constrained();$t->foreignId('floor_id')->constrained();$t->foreignId('room_id')->constrained();$t->string('category');$t->string('title');$t->text('description');$t->enum('status',['received','handling','scheduled','completed'])->default('received');$t->date('planned_date')->nullable();$t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();$t->timestamps();$t->index(['status','created_at']);});
 Schema::create('report_updates',function(Blueprint $t){$t->id();$t->foreignId('report_id')->constrained()->cascadeOnDelete();$t->foreignId('user_id')->constrained();$t->string('status');$t->text('note')->nullable();$t->date('planned_date')->nullable();$t->timestamps();});
 Schema::create('attachments',function(Blueprint $t){$t->id();$t->foreignId('report_id')->constrained()->cascadeOnDelete();$t->string('path');$t->string('mime');$t->string('original_name');$t->unsignedBigInteger('size');$t->timestamps();});
 }
 public function down():void {foreach(['attachments','report_updates','reports','rooms','floors','buildings','locations','sessions','password_reset_tokens','users'] as $table)Schema::dropIfExists($table);}
};
