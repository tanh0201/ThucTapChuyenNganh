<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class UpdateUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật role_id cho các user dựa trên email hoặc gán role mặc định';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu cập nhật role_id cho users...');

        // Lấy các role
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        if (!$adminRole || !$userRole) {
            $this->error('Không tìm thấy role admin hoặc user trong database!');
            return 1;
        }

        // Admin user
        User::where('email', 'admin@petsamai.com')->update(['role_id' => $adminRole->id]);
        $this->line('✓ Cập nhật admin@petsamai.com -> Admin role');

        // Cập nhật users không có role_id thành user role
        $updatedCount = User::whereNull('role_id')->update(['role_id' => $userRole->id]);
        $this->line('✓ Cập nhật ' . $updatedCount . ' user(s) -> User role');

        // Hiển thị thống kê
        $this->newLine();
        $this->info('Thống kê hiện tại:');
        foreach (Role::all() as $role) {
            $count = User::where('role_id', $role->id)->count();
            $this->line("  {$role->display_name}: {$count} user(s)");
        }

        $this->info('Cập nhật hoàn tất!');
        return 0;
    }
}
