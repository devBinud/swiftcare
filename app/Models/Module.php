<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory;

    /*
    --------------------------------------------------------------
    READ
    --------------------------------------------------------------
    */

    public static function getModuleBySlug(string $slug)
    {
        return DB::table('module as m')
            ->select(
                'm.*',
                'ma.role'
            )
            ->leftJoin('module_access as ma', 'ma.module_id', 'm.id')
            ->where('m.slug', $slug)
            ->first();
    }

    public static function getModuleAccessAll()
    {
        return DB::table('module_access as ma')
            ->select(
                'm.id as module_id',
                'm.module_name',
                'm.slug',
                'ma.role'
            )
            ->leftJoin('module as m', 'ma.module_id', 'm.id')
            ->get();
    }

    public static function getSubModuleAccessBySlug(string $moduleSlug, string $subModuleSlug)
    {
        return DB::table('sub_module_access as sma')
            ->select(
                'sma.id',
                'sma.role_id',
                'r.role',
                'sma.create',
                'sma.read',
                'sma.update',
                'sma.delete'
            )
            ->leftJoin('sub_module as sm', 'sma.sub_module_id', 'sm.id')
            ->leftJoin('module as m', 'sm.module_id', 'm.id')
            ->leftJoin('role as r', 'sma.role_id', 'r.id')
            ->where([
                ['m.slug', $moduleSlug],
                ['sm.slug', $subModuleSlug]
            ])
            ->get();
    }

}