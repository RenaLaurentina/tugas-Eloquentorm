<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // Pastikan nama tabel sesuai di database
    protected $primaryKey = 'user_id'; // Pastikan primary key sesuai
    
    // Sangat penting: Laravel default-nya menganggap timestamps ada. 
    // Jika di tabel m_user Anda tidak ada created_at/updated_at, ini harus false.
    public $timestamps = false; 

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password'
    ];

    /**
     * Seringkali kolom password ikut terkirim ke DataTables.
     * Untuk keamanan dan menghindari error data yang terlalu besar,
     * kita sembunyikan password dari JSON.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Mendapatkan level yang dimiliki oleh user.
     * Relasi ini WAJIB ada agar DataTables bisa memanggil 'level.level_nama'.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
