<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Komens extends Model
{
    use HasFactory;
    protected $fillable = [
        'komen', 'feedid', 'usersid' 
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
    public function feed()
    {
        return $this->belongsTo('App\Models\Feed','feedid');
    } 
}
