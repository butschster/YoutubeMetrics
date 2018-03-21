<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Регистрация нового пользователя';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        do {
            $name = $this->ask('Имя');
            $email = $this->ask('Email адрес');
            $password = $this->secret('Пароль');

            if (empty($password)) {
                $password = $confirmation = generate_password();
            } else {
                $confirmation = $this->secret('Подтверждение пароля');
            }

            $validator = validator([
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'password_confirmation' => $confirmation
            ], [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->error($error);
                    }
                }
            }

        } while ($validator->fails());

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('Пользователь создан.');
        $this->info('Email: '.$email);
        $this->info('Пароль: '.$password);
    }
}
