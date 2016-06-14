<?php

namespace App\Components\Auth;

use App\Models\User;
use App\Models\UserSession;
use T4\Http\Helpers;


class Identity
{
    public function login($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add( new Exception('Пустой email') );
        }
        if (empty($data->password)) {
            $errors->add( new Exception('Пустой пароль') );
        }
        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);
        if (empty($user)) {
            $errors->add( new Exception('Пользователь с таким email не найден') );
            throw $errors;
        }

        if (!password_verify($data->password, $user->password)) {
            $errors->add( new Exception('Неверный пароль') );
            throw $errors;
        }
        $hash = sha1(microtime() . mt_rand());
        $session = new UserSession();
        $session->hash = $hash;
        $session->user = $user;
        $session->save();
        Helpers::setCookie('auth', $hash, time() + 30*24*60*60);
    }

    public function register($data)
    {
        $errors = new MultiException();

        if ($data->rules != 'on') {
            $errors->add( new Exception('Необходимо согласиться с правилами') );
        }

        if (empty($data->firstName)) {
            $errors->add( new Exception('Необходимо ввести имя') );
        }

        if (empty($data->lastName)) {
            $errors->add( new Exception('Необходимо ввести фамилию') );
        }

        if (empty($data->email)) {
            $errors->add( new Exception('Необходимо ввести email') );
        }

        if (empty($data->password)) {
            $errors->add( new Exception('Необходимо ввести пароль') );
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        unset($data->rules);
        $old_password = $data->password;
        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        try {
            User::create($data);
        } catch (\T4\Core\MultiException $e) {
            $errors->merge($e);
            throw $errors;
        }
        $data->password = $old_password;
        $this->login($data);

    }

    public function logout()
    {
        if (Helpers::issetCookie('auth') && !empty($hash = Helpers::getCookie('auth'))) {
            Helpers::unsetCookie('auth');
            $session = UserSession::findByHash($hash);
            if (!empty($session)) {
                $session->delete();
            }
        }
    }

    public function getUser()
    {
        if (Helpers::issetCookie('auth') && !empty($hash = Helpers::getCookie('auth'))) {
            if (!empty($session = UserSession::findByHash($hash))) {
                return $session->user;
            }
        }
        return null;
    }
}