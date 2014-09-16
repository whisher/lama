<?php
namespace App\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Cartalyst\Sentry\Users\Eloquent\User {

    /**
     * Returns the fullname for the user.
     *
     * @return string
     */
    public function getFullname() {
        return $this->fullname;
    }

    /**
     * Returns the username for the user.
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Returns the email for the user.
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Returns the activated status for the user.
     *
     * @return integer
     */
    public function getActivated() {
        return $this->activated;
    }
}