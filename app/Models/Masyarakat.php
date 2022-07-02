<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = "tb_masyarakat";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'nama',
        'telp',
        'alamat',
        'alamat',
        'img',
        'gender',
        'role',
    ];
}
