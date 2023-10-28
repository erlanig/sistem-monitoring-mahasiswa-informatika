<?php

namespace App\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Session;

class CustomSessionGuard implements Guard
{
    protected $provider;
    protected $session;

    public function __construct(UserProvider $provider, Session $session)
    {
        $this->provider = $provider;
        $this->session = $session;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        // Implementasikan logika untuk mengambil pengguna dari sesi
        $userId = $this->session->get('user_id');
        $this->user = $this->provider->retrieveById($userId);

        return $this->user;
    }

    public function id()
    {
        return $this->user() ? $this->user()->getAuthIdentifier() : null;
    }

    public function validate(array $credentials = [])
    {
        // Implementasikan logika validasi kustom berdasarkan kredensial yang diberikan
    }
}
