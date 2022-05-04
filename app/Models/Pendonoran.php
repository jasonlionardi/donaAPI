<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendonoran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_pendonoran',
        'waktu_donor',
        'location',
        'user_id',
        'pendonoran_ke',
        'petugas_periksa',
        'hemoglobin',
        'berat_badan',
        'tensi',
        'cc_diambil',
        'kembali_setelah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
