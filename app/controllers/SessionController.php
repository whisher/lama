<?php
namespace App\Controllers;

use \Controller,
    \Event,
    \Input,
    \Redirect,
    \Response;

use Users\Session\SessionInterface;
use Users\Form\Signin\SigninForm;

class SessionController extends Controller {

    protected $session;
    protected $signinForm;

    public function __construct(SessionInterface $session, SigninForm $signinForm) 
    {
        $this->session = $session;
        $this->signinForm = $signinForm;
    }

    /**
     * Try to login user.
     *
     * @return json
     */
    public function store() 
    { 
        $isValid = $this->signinForm->valid(Input::only('email', 'password'));
        if ($isValid) {
            $result = $this->session->store($this->signinForm->data());
            if (isset($result['user']) && $result['success']) {
                Event::fire('user.register', $result['user']);
                return Response::json($result, 200);
            }
            $error = isset($result['error'])?array_pop($result):trans('session.invalid');
            return Response::json(array(
                        'success' => 0,
                        'errors' => array('error' => array($error))), 200);
        }
        return Response::json(array(
                    'success' => 0,
                    'errors' => $this->signinForm->errors()), 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Redirect
     */
    public function destroy() {
        $this->session->destroy();
        Event::fire('session.logout');
        return Redirect::route('home');
    }

}
