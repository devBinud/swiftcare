<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Master extends Model
{
    use HasFactory;

    /*
    --------------------------------------------------------------
    Department
    --------------------------------------------------------------
    */

    // ::::::::::::::::: CHECK :::::::::::::::::
    public static function isDepartmentIdValid($id)
    {
        return DB::table('master_department')->where('id', $id)->count() > 0;
    }

    // ::::::::::::::::: READ :::::::::::::::::
    public static function getDepartmentsAll()
    {
        return DB::table('master_department')->orderBy('department')->get();
    }

    public static function getDepartmentsByHospitalIds(array $hospitalIds)
    {
        return DB::table('master_department')->whereIn('id', $hospitalIds)->get();
    }

    /*
    --------------------------------------------------------------
    Specialities
    --------------------------------------------------------------
    */

    // ::::::::::::::::: READ :::::::::::::::::

    public static function isSpecialitiesValid(array $ids)
    {
        return DB::table('master_speciality')->whereIn('id', $ids)->count() == count($ids);
    }

    public static function getSpecialities(int $perPage = 0)
    {
        return $perPage == 0 ? DB::table('master_speciality')->get() : DB::table('master_speciality')->paginate($perPage);
    }

    public static function getSpecialitiesInUse()
    {
        return DB::table('master_speciality as s')
            ->select('s.*')
            ->join('doctor as d', DB::raw('FIND_IN_SET(s.id, d.speciality_ids)'), '>', DB::raw('0'))
            ->join('doctor_clinic_time as t', 'd.id', 't.doctor_id')
            ->orderBy('s.name')
            ->groupBy('s.id')
            ->get();
    }

    /*
    --------------------------------------------------------------
    Weekdays
    --------------------------------------------------------------
    */

    public static function getWeekDays()
    {
        return DB::table('master_week_day')->get();
    }

}
