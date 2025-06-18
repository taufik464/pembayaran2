<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'tingkatan',
        'status',
    ];

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = strtoupper($value);
    }

    public function setTingkatanAttribute($value)
    {
        $this->attributes['tingkatan'] = strtoupper($value);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
