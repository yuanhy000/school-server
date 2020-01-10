<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNumberIncrement extends Model
{
    protected $guarded = [];

    public static function NumberIncrement()
    {
        $number = self::first();
        $number->user_number += 1;
        $number->save();
    }
}
