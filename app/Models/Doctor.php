<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Doctor extends Model
{

    /*
    --------------------------------------------------------------
    CHECK
    --------------------------------------------------------------
    */

    public static function isDoctorValid($id)
    {
        return DB::table('doctor')->where('id', $id)->count() > 0;
    }

    public static function isDoctorClinicTimeValid($id)
    {
        return DB::table('doctor_clinic_time')->where('id', $id)->count() > 0;
    }

    /*
    --------------------------------------------------------------
    READ
    --------------------------------------------------------------
    */

    public static function getDoctors(string $select = null, string $whereRaw = '1=?', array $whereParam = [1], int $perPage = 12)
    {
        $q = DB::table('doctor as d');
        if ($select != null) {
            $q = $q->select(DB::raw($select));
        } else {
            $q = $q->select('d.*');
        }
        $q = $q->whereRaw($whereRaw, $whereParam);
        $q = $q->groupBy('d.id');
        $q = $q->leftJoin('master_speciality as s', DB::raw('FIND_IN_SET(s.id, d.speciality_ids)'), '>', DB::raw('"0"'));
        return $perPage == 0 ? $q->get() : $q->paginate($perPage);
    }

    public static function getDoctorSingle($doctorId, string $select = null)
    {
        $q = DB::table('doctor as d');
        if ($select != null) {
            $q = $q->select(DB::raw($select));
        } else {
            $q = $q->select('d.*');
        }
        Session::get('d.admin_id', null) == null ? $q->where('d.is_active', 1) : $q;
        $q = $q->groupBy('d.id');
        $q = $q->leftJoin('master_speciality as s', DB::raw('FIND_IN_SET(s.id, d.speciality_ids)'), '>', DB::raw('"0"'));
        return $q->where('d.id', $doctorId)->first();
    }

    public static function getDoctorClinicTime($doctorId, $clinicId)
    {
        return DB::table('doctor_clinic_time as ct')
            ->select(
                'ct.id',
                'ct.clinic_id',
                DB::raw('GROUP_CONCAT(ct.id ORDER BY w.id) as schedule_ids'),
                DB::raw('GROUP_CONCAT(ct.week_day_id ORDER BY w.id) as week_day_ids'),
                DB::raw('GROUP_CONCAT(w.name ORDER BY w.id) as weekdays'),
                DB::raw('GROUP_CONCAT(ct.time_from ORDER BY w.id) as time_from'),
                DB::raw('GROUP_CONCAT(ct.time_to ORDER BY w.id) as time_to'),
            )
            ->leftJoin('master_week_day as w', 'ct.week_day_id', 'w.id')
            ->where([
                ['ct.doctor_id', $doctorId],
                ['ct.clinic_id', $clinicId]
            ])
            ->get();
    }

    public static function getDoctorClinicTimeSingle($id, string $select = null)
    {
        $query = DB::table('doctor_clinic_time as ct');
        if ($select == null) {
            $query->select('ct.*');
        } else {
            $query->select(DB::raw($select));
        }
        return $query->leftJoin('master_week_day as w', 'ct.week_day_id', 'w.id')
            ->where('ct.id', $id)
            ->first();
    }

    /*
    --------------------------------------------------------------
    CREATE
    --------------------------------------------------------------
    */

    public static function addDoctor(array $values)
    {
        return DB::table('doctor')->insert($values);
    }

    public static function addDoctorClinicTime(array $values)
    {
        return DB::table('doctor_clinic_time')->insert($values);
    }

    /*
    --------------------------------------------------------------
    UPDATE
    --------------------------------------------------------------
    */

    public static function editDoctor($id, array $values)
    {
        return DB::table('doctor')->where('id', $id)->update($values);
    }

    public static function updateDoctorClinicTime($id, array $values)
    {
        return DB::table('doctor_clinic_time')->where('id', $id)->update($values);
    }
}
