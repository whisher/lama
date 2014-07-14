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
        $events->listen('user.mail.forgot', 'Users\Mailer\UserMailer@forgot');
        $events->listen('user.mail.newpassword', 'Users\Mailer\UserMailer@newPassword');
    }

    /**
     * Send a confirmation email.
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
     * Send a reset password email.
     * 
     * @param  $data  array
     * 		
     * @return bool
     */
    public function forgot($data) 
    {
        $subject = trans('mails.forgot');
        $view = 'emails.user.forgot';
        return $this->sendTo($data['email'], $subject, $view, $data);
    }

    /**
     * Email New Password info to user.
     *      
     * @param  $data array  
     *		
     * @return bool
     */
    public function newPassword($data) 
    {
        $subject = trans('mails.newpassword');
        $view = 'emails.user.newpassword';
        return $this->sendTo($data['email'], $subject, $view, $data);
    }

}