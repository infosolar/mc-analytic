<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Class CreateUser
 * @package App\Console\Commands
 */
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stat-api:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user for dashboard';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->ask(__('dashboard.create_user.name'));
        if (empty($name)) {
            $this->error(__('dashboard.create_user.name_input_error'));
        }

        $email = $this->ask(__('dashboard.create_user.email'));
        if (empty($email)) {
            $this->error(__('dashboard.create_user.email_input_error'));
        }

        $password = $this->secret(__('dashboard.create_user.password'));
        $confirm_password = $this->secret(__('dashboard.create_user.confirm_password'));
        if ($password !== $confirm_password) {
            $this->error(__('dashboard.create_user.password_input_error'));
        }

        if (User::firstWhere('email', $email)) {
            $this->error(__('dashboard.create_user.email_busy'));
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $this->info(__('dashboard.create_user.done'));
        }
        return 0;
    }
}
