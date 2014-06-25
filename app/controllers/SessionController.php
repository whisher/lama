<?php
namespace App\Controllers;

use \Controller,
    \Event,
    \Input,
    \Redirect,
    \Response;

use Authority\Repo\Session\SessionInterface;
use Authority\Service\Form\Login\LoginForm;

class SessionController extends Controller {

    protected $session;
    protected $loginForm;

    public function __construct(SessionInterface $session, LoginForm $loginForm) 
    {
        $this->session = $session;
        $this->loginForm = $loginForm;
    }

    /**
     * Try to login user.
     *
     * @return json
     */
    public function store() 
    { 
        
        $result = $this->loginForm->save(Input::all());
        if (isset($result['user']) && $result['success']) {
            Event::fire('user.register', $result['user']);
            return Response::json($result,200);
        } 
        if (isset($result['error'])) {
            $error = array_pop($result);
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        } 
        return Response::json(array(
                'success'=>0,
                'errors' => $this->loginForm->errors()),
                200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        $this->session->destroy();
        Event::fire('session.logout');
        return Redirect::route('home');
    }

}
