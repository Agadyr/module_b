<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function tokens()
    {
        return $this->hasMany(Token::class)->withTrashed();

    }
    public function quota()
    {
        return $this->hasOne(Quota::class)->first();

    }


}
