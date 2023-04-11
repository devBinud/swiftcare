<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Hospital extends Model
{
    use HasFactory;

    /*
    --------------------------------------------------------------
    CHECK
    --------------------------------------------------------------
    */

    public static function isHospitalValid($id)
    {
        return DB::table('hospital')->where('id', $id)->count() > 0;
    }

    /*
    --------------------------------------------------------------
    READ
    --------------------------------------------------------------
    */

    public static function isHospitalAvailableByUsername(string $username)
    {
        return DB::table('hospital')->where('username', $username)->count() > 0;
    }

    public static function getHospitals(string $select = null, int $perPage = 12)
    {
        $q = DB::table('hospital');
        if ($select != null) {
            $q = $q->select(DB::raw($select));
        }
        Session::get('admin_id', null) == null ? $q->where('is_active', 1) : $q;
        return $perPage == 0 ? $q->get() : $q->paginate($perPage);
    }

    public static function getHospital($id, string $select = null)
    {
        $query = DB::table('hospital as h');
        $query = $select != null ? $query->select(DB::raw($select)) :
            $query->select(
                'h.*',
                DB::raw('GROUP_CONCAT(d.department ORDER BY d.department) as departments')
            );
        return $query->leftJoin('master_department as d', DB::raw('FIND_IN_SET(d.id, h.departments)'), '>', DB::raw('"0"'))
            ->where('h.id', $id)
            ->first();
    }

    public static function getHospitalByUsername(string $username, string $select = null)
    {
        $query = DB::table('hospital as h');
        if ($select != null) {
            $query = $query->select(DB::raw($select));
        }
        return $query->where('username', $username)->first();
    }

    public static function getPreviousId(int $id)
    {
        return DB::table('hospital')
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->first('id');
    }

    public static function getNextId(int $id)
    {
        return DB::table('hospital')
            ->where('id', '>', $id)
            ->orderBy('id')
            ->first('id');
    }

    /*
    --------------------------------------------------------------
    CREATE
    --------------------------------------------------------------
    */

    public static function createHospital(array $values)
    {
        return DB::table('hospital')->insert($values);
    }
}
