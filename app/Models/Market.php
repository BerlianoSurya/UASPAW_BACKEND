<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang', 'deskripsi', 'judul_barang', 'path_barang','usersid', 'harga'
    ];
    public function getCreatedAtAttribute()
    {
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }
    public function getUpdatedAtAttribute()
    {
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','usersid');
    } 
}
