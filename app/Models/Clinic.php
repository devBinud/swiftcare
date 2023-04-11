<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Clinic extends Model
{
     /*
    --------------------------------------------------------------
    CHECK
    --------------------------------------------------------------
    */

    public static function isClinicValid($id)
    {
        return DB::table('clinic')->where('id', $id)->count() > 0;
    }

    public static function isClinicIdsValid(array $ids)
    {
        return DB::table('clinic')->whereIn('id', $ids)->count() == count($ids);
    }

    /*
    --------------------------------------------------------------
    READ
    --------------------------------------------------------------
    */

    public static function isClinicAvailableByUsername(string $username)
    {
        return DB::table('clinic')->where('username', $username)->count() > 0;
    }

    public static function getClinics(string $select = null, string $whereRaw = '1=?', array $whereParam = [1], int $perPage = 12)
    {
        $q = DB::table('clinic as c');
        if ($select != null) {
            $q = $q->select(DB::raw($select));
        }
        $q = $q->whereRaw($whereRaw, $whereParam);
        return $perPage == 0 ? $q->get() : $q->paginate($perPage);
    }

    public static function getClinicsByIds(array $ids)
    {
        return DB::table('clinic')->whereIn('id', $ids)->get();
    }

    public static function getClinic($id, string $select = null)
    {
        $query = DB::table('clinic');
        $query = $select != null ? $query->select(DB::raw($select)) : $query;
        return $query->where('id', $id)->first();
    }

    public static function getPreviousId(int $id)
    {
        return DB::table('clinic')
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->first('id');
    }

    public static function getNextId(int $id)
    {
        return DB::table('clinic')
            ->where('id', '>', $id)
            ->orderBy('id')
            ->first('id');
    }

    public static function getClinicsForDoctor($doctorId)
    {
        return DB::table('doctor as d')
            ->select('c.*')
            ->join('doctor_clinic_time as t', 'd.id', 't.doctor_id')
            ->join('clinic as c', DB::raw('FIND_IN_SET(c.id, d.clinic_ids)'), '>', DB::raw('0'))
            ->where('d.id', $doctorId)
            ->groupBy('c.id')
            ->get();
    }

    public static function getDoctorClinicWithTimeSlots($doctorId, array $clinicIds)
    {
        return DB::table('clinic as c')
            ->select(
                'c.id as clinic_id',
                'c.name as clinic',
                'c.thumbnail',
                'c.address',
                DB::raw('GROUP_CONCAT(ct.week_day_id ORDER BY w.id) as week_day_ids'),
                DB::raw('GROUP_CONCAT(w.name ORDER BY w.id) as weekdays'),
                DB::raw('GROUP_CONCAT(ct.time_from ORDER BY w.id) as time_from'),
                DB::raw('GROUP_CONCAT(ct.time_to ORDER BY w.id) as time_to'),
            )
            ->leftJoin('doctor_clinic_time as ct', 'c.id', 'ct.clinic_id')
            ->leftJoin('master_week_day as w', DB::raw('FIND_IN_SET(w.id, (SELECT GROUP_CONCAT(ct.week_day_id)))'), '>', DB::raw('0'))
            ->whereIn('c.id', $clinicIds)
            ->orWhere('ct.doctor_id', $doctorId)
            ->groupBy('ct.clinic_id')
            ->get();
    }

    /*
    --------------------------------------------------------------
    CREATE
    --------------------------------------------------------------
    */

    public static function createClinic(array $values)
    {
        return DB::table('clinic')->insert($values);
    }
}
