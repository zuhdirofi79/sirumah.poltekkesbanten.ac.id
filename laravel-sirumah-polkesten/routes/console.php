<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
Artisan::command('sirumah:admin {email} {--role=superadmin}', function () {
    $email = strtolower(trim($this->argument('email')));
    $allowed = ['singgih.handika@poltekkesbanten.ac.id', 'webmaster@poltekkesbanten.ac.id', 'qowiyrofi@poltekkesbanten.ac.id'];
    if ($this->option('role') === 'superadmin' && !in_array($email,$allowed,true)) { $this->error('Email ini tidak termasuk daftar superadmin.'); return 1; }
    if (!in_array($this->option('role'),['superadmin','verifier','admin'],true)) { $this->error('Role tidak valid.'); return 1; }
    $password = $this->secret('Kata sandi baru (minimal 12 karakter)');
    if (strlen((string)$password) < 12) { $this->error('Kata sandi terlalu pendek.'); return 1; }
    User::updateOrCreate(['email'=>$email], ['name'=>explode('@',$email)[0], 'password'=>Hash::make($password),'role'=>$this->option('role'),'is_active'=>true,'email_verified_at'=>now()]);
    $this->info('Akun berhasil dibuat/diperbarui.');
});
