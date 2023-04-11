<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{

    public static function isRoleAssignedToStaff($staffId, array $roles)
    {
        $whereRaw = "";
        foreach ($roles as $role) {
            $whereRaw .= "FIND_IN_SET('$role', (SELECT GROUP_CONCAT(mr.name) FROM master_staff_role mr_ WHERE FIND_IN_SET(mr_.id, s.roles))) > 0 OR ";
        }
        $whereRaw = substr($whereRaw, 0, -4);

        return DB::table('staff as s')
            ->leftJoin('master_staff_role as mr', DB::raw('FIND_IN_SET(mr.id, s.roles)'), '>', DB::raw("'0'"))
            ->whereRaw($whereRaw)
            ->where('s.id', $staffId)
            ->groupBy('s.id')
            ->count() > 0;
    }

    public static function getStaffByRole(string $role, string $select = null)
    {
        $query = DB::table('staff as s');
        $query = $select == null ? $query->select('s.id', 's.name', 's.phone', 's.email', 's.address') : $query->select(DB::raw($select));

        return $query->leftJoin('master_staff_role as mr', DB::raw('FIND_IN_SET(mr.id, s.roles)'), '>', DB::raw("'0'"))
            ->whereRaw("FIND_IN_SET('$role', (SELECT GROUP_CONCAT(mr.name) FROM master_staff_role mr_ WHERE FIND_IN_SET(mr_.id, s.roles))) > 0")
            ->groupBy('s.id')
            ->get();
    }
}
