<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;

    /*
    --------------------------------------------------------------
    READ
    --------------------------------------------------------------
    */

    public static function getAdmin(int $userId)
    {
        return DB::table('admin')
            ->where('id', $userId)
            ->first();
    }

    public static function getAdminByPhoneOrEmail($phoneOrEmail)
    {
        return DB::table('admin')
            ->where('phone', $phoneOrEmail)
            ->orWhere('email', $phoneOrEmail)
            ->first();
    }
}
