<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{

    /*
    -----------------------------------------------------------------
    CHECK
    -----------------------------------------------------------------
    */

    public static function isBookingIdValid($id)
    {
        return DB::table('booking')->where('id', $id)->count() > 0;
    }

    /*
    -----------------------------------------------------------------
    READ
    -----------------------------------------------------------------
    */

    public static function getTotalUnreadBookings()
    {
        return DB::table('booking')->where('is_read', 0)->count();
    }

    public static function getBookings(string $select = null, string $whereRaw = '1=?', array $whereParam = [1], int $perPage = 20)
    {
        $query = DB::table('booking');
        $query = $select != null ? $query->select(DB::raw($select)) : $query;
        $query = $query->whereRaw($whereRaw, $whereParam)->orderBy('is_read')->orderByDesc('id');
        return $perPage == 0 ? $query->get() : $query->paginate($perPage);
    }

    public static function getBookingsForHospital(string $select = null, string $whereRaw = '1=?', array $whereParam = [1], int $perPage = 20)
    {
        $query = DB::table('booking as b');
        $query = $select != null ? $query->select(DB::raw($select)) : $query;
        $query = $query->join('booking_hospital as h', 'b.id', 'h.booking_id');
        $query = $query->whereRaw($whereRaw, $whereParam)->orderBy('h.status');
        return $perPage == 0 ? $query->get() : $query->paginate($perPage);  
    }

    public static function countHospitalBookingByStatus(string $status, array $ids = null)
    {
        $query = DB::table('booking_hospital');
        if ($ids != null && is_array($ids)) {
            $query = $query->whereIn('booking_id', $ids);
        }
        return $query->where('status', $status)->count();
    }

    public static function getBookingSingle($id)
    {
        return DB::table('booking as b')
            ->select(
                'b.*',
                'a1.name as read_by',
                'a2.name as created_by',
                'a3.name as updated_by',
            )
            ->leftJoin('admin as a1', 'b.read_by', 'a1.id')
            ->leftJoin('admin as a2', 'b.created_by', 'a2.id')
            ->leftJoin('admin as a3', 'b.updated_by', 'a3.id')
            ->where('b.id', $id)
            ->first();
    }

    public static function getHospitalBookingSingle($bookingId)
    {
        return DB::table('booking_hospital as bh')
            ->select(
                'bh.*',
                'h.name as hospital',
                'd.department',
            )
            ->leftJoin('master_department as d', 'bh.department_id', 'd.id')
            ->leftJoin('hospital as h', 'bh.hospital_id', 'h.id')
            ->where('booking_id', $bookingId)
            ->first();
    }

    public static function getBookingRemarks($bookingId)
    {
        return DB::table('booking_remark as r')
            ->select(
                'r.*',
                'a.name as remarked_by'
            )
            ->leftJoin('admin as a', 'r.created_by', 'a.id')
            ->where('r.booking_id', $bookingId)
            ->orderByDesc('r.id')
            ->get();
    }

    public static function getBookingAssignedStaff($bookingId, $select = null)
    {
        $query = DB::table('booking_staff_assign');
        $query = $select != null ? $query->select(DB::raw($select)) : $query;
        return $query->where('booking_id', $bookingId)->first();
    }

    public static function getDoctorBooking($bookingId)
    {
        return DB::table('booking_doctor as bd')
            ->select(
                'bd.booking_date',
                'bd.time_from',
                'bd.time_to',
                'd.name as doctor_name',
                'c.name as clinic_name'
            )
            ->leftJoin('doctor as d', 'd.id', 'bd.doctor_id')
            ->leftJoin('clinic as c', 'c.id', 'bd.clinic_id')
            ->where('bd.booking_id', $bookingId)
            ->first();
    }

    /*
    -----------------------------------------------------------------
    CREATE
    -----------------------------------------------------------------
    */

    public static function createBooking(array $values)
    {
        return DB::table('booking')->insertGetId($values);
    }

    public static function createBookingRemark(array $values)
    {
        return DB::table('booking_remark')->insert($values);
    }

    public static function createBookingDoctor(array $values)
    {
        return DB::table('booking_doctor')->insert($values);
    }

    /*
    -----------------------------------------------------------------
    UPDATE
    -----------------------------------------------------------------
    */

    public static function updateBooking(int $id, array $values)
    {
        return DB::table('booking')->where('id', $id)->update($values);
    }

    public static function updateHospitalBooking($bookingId, array $values)
    {
        return DB::table('booking_hospital')->updateOrInsert(
            ['booking_id' => $bookingId],
            $values
        );
    }

    public static function updateBookingStaffAssign($bookingId, array $values)
    {
        return DB::table('booking_staff_assign')->updateOrInsert(
            ['booking_id' => $bookingId],
            $values
        );
    }

    public static function updateHospitalBookingMultiple(array $bookingIds, array $values)
    {
        return DB::table('booking_hospital')->whereIn('booking_id', $bookingIds)->update($values);
    }
}
