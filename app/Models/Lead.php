<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    protected $fillable = [
        'name','email','phone','scoring'
    ];

    public function scopeSearch($query, $search){
        return $query->where('name', 'like', '%' . $search . '%')
        ->orWhere('email', 'like', '%' . $search . '%')
        ->orWhere('phone', 'like', '%' . $search . '%');
    }
}
