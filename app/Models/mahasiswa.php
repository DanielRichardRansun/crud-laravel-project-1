<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    //mengizinkan tabel pada database untuk diisi
    protected $fillable = ['nim', 'nama', 'jurusan'];
    protected $table = 'mahasiswa'; //nama tabel
    public $timestamps = false; //mengkonfirmasi tidak ada timestamps agar tidak error pada web
}
