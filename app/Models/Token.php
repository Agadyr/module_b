<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function billings()
    {
        return $this->hasMany(Billings::class);
    }
    public function tokentype()
    {
        return $this->belongsTo(Tokentype::class);
    }
}
