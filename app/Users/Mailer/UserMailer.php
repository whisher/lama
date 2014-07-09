<?php namespace Users\Mailer;

 class UserMailer extends Mailer {

    /**
     * Outline all the events this class will be listening for. 
     * 
     * @param  [type] $events 
     * 
     * @return void         
     */
    public function subscribe($events) 
    {
        $events->listen('user.mail.register', 'Users\Mailer\UserMailer@register');
        $events->listen('user.mail.resend', 'Users\Mailer\UserMailer@welcome');
        $events->listen('user.mail.forgot', 'Users\Mailer\UserMailer@forgotPassword');
        $events->listen('user.mail.newpassword', 'Users\Mailer\UserMailer@newPassword');
    }

    /**
     * Send a welcome email to a new user.
     * 
     * @param  $data  array
     * 		
     * @return bool
     */
    public function register($data) 
    {
        $subject = trans('mails.register');
        $view = 'emails.user.register';
        return $this->sendTo($data['email'], $subject, $view, $data);
    }

    /**
     * Email Password Reset info to a user.
     * @param  string $email          
     * @param  int    $userId         
     * @param  string $resetCode 		
     * @return bool
     */
    public function forgotPassword($email, $userId, $resetCode) {
        $subject = 'Password Reset Confirmation | Laravel4 With Sentry';
        $view = 'emails.auth.reset';
        $data['userId'] = $userId;
        $data['resetCode'] = $resetCode;
        $data['email'] = $email;

        return $this->sendTo($email, $subject, $view, $data);
    }

    /**
     * Email New Password info to user.
     * @param  string $email          
     * @param  int    $userId         
     * @param  string $resetCode 		
     * @return bool
     */
    public function newPassword($email, $newPassword) {
        $subject = 'New Password Information | Laravel4 With Sentry';
        $view = 'emails.auth.newpassword';
        $data['newPassword'] = $newPassword;
        $data['email'] = $email;

        return $this->sendTo($email, $subject, $view, $data);
    }

}