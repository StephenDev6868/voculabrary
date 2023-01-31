<?php

namespace Database\Seeders;

use App\Common\AllPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', SUPER_ADMIN)->first();

        if (empty($role)) {
            $role = Role::create([
                'name' => SUPER_ADMIN,
                'slug' => strSlugName(SUPER_ADMIN)
            ]);
        }

        $danhMuc = Permission::findOrCreate(AllPermission::danhMuc());
        Permission::findOrCreate(AllPermission::xemDanhMuc(), $danhMuc->id);
        Permission::findOrCreate(AllPermission::themDanhMuc(), $danhMuc->id);
        Permission::findOrCreate(AllPermission::suaDanhMuc(), $danhMuc->id);
        Permission::findOrCreate(AllPermission::xoaDanhMuc(), $danhMuc->id);

        $banner = Permission::findOrCreate(AllPermission::banner());
        Permission::findOrCreate(AllPermission::xemBanner(), $banner->id);
        Permission::findOrCreate(AllPermission::themBanner(), $banner->id);
        Permission::findOrCreate(AllPermission::suaBanner(), $banner->id);
        Permission::findOrCreate(AllPermission::xoaBanner(), $banner->id);

        $cauHoi = Permission::findOrCreate(AllPermission::cauHoi());
        Permission::findOrCreate(AllPermission::xemCauHoi(), $cauHoi->id);
        Permission::findOrCreate(AllPermission::themCauHoi(), $cauHoi->id);
        Permission::findOrCreate(AllPermission::suaCauHoi(), $cauHoi->id);
        Permission::findOrCreate(AllPermission::xoaCauHoi(), $cauHoi->id);

        $khachHang = Permission::findOrCreate(AllPermission::khachHang());
        Permission::findOrCreate(AllPermission::xemKhachHang(), $khachHang->id);
        Permission::findOrCreate(AllPermission::themKhachHang(), $khachHang->id);
        Permission::findOrCreate(AllPermission::suaKhachHang(), $khachHang->id);
        Permission::findOrCreate(AllPermission::xoaKhachHang(), $khachHang->id);

        $gopYNguoiDung = Permission::findOrCreate(AllPermission::gopYNguoiDung());
        Permission::findOrCreate(AllPermission::xemDanhSachGopY(), $gopYNguoiDung->id);

        $thongBao = Permission::findOrCreate(AllPermission::thongBao());
        Permission::findOrCreate(AllPermission::xemDanhSachThongBao(), $thongBao->id);
        Permission::findOrCreate(AllPermission::themThongBao(), $thongBao->id);
        Permission::findOrCreate(AllPermission::suaThongBao(), $thongBao->id);
        Permission::findOrCreate(AllPermission::xoaThongBao(), $thongBao->id);

        $cauHinhThongTin = Permission::findOrCreate(AllPermission::cauHinhThongTin());
        Permission::findOrCreate(AllPermission::xemCauHinhThongTin(), $cauHinhThongTin->id);
        Permission::findOrCreate(AllPermission::themCauHinhThongTin(), $cauHinhThongTin->id);
        Permission::findOrCreate(AllPermission::suaCauHinh(), $cauHinhThongTin->id);
        Permission::findOrCreate(AllPermission::xoaCauHinh(), $cauHinhThongTin->id);

        $quanLyQuyenHan = Permission::findOrCreate(AllPermission::quanLyQuyenHan());
        Permission::findOrCreate(AllPermission::xemQuyenHan(), $quanLyQuyenHan->id);
        Permission::findOrCreate(AllPermission::themQuyenHan(), $quanLyQuyenHan->id);
        Permission::findOrCreate(AllPermission::suaQuyenHan(), $quanLyQuyenHan->id);
        Permission::findOrCreate(AllPermission::xoaQuyenHan(), $quanLyQuyenHan->id);

        $quanLyTaiKhoan = Permission::findOrCreate(AllPermission::quanLyTaiKhoan());
        Permission::findOrCreate(AllPermission::xemDanhSachTaiKhoan(), $quanLyTaiKhoan->id);
        Permission::findOrCreate(AllPermission::themTaiKhoan(), $quanLyTaiKhoan->id);
        Permission::findOrCreate(AllPermission::suaTaiKhoan(), $quanLyTaiKhoan->id);
        Permission::findOrCreate(AllPermission::xoaTaiKhoan(), $quanLyTaiKhoan->id);

        $allPermissions = Permission::where('parent_id', '!=', 0)->get();
        $user = User::where('name', 'admin')->where('status', 1)->select('id', 'name')->first();
        if ($allPermissions && $user) {
            $user->roles()->attach($role);
            foreach ($allPermissions as $permission)
            {
                $role->permissions()->attach($permission);
                $user->permissions()->attach($permission);
            }
        }
    }
}
