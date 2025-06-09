<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'jabatan',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
