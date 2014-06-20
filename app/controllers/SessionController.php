<?php
namespace App\Controllers;

use \Event,
    \Input;

use Authority\Repo\Session\SessionInterface;
use Authority\Service\Form\Login\LoginForm;

class SessionController extends Controller {

    

    /**
     * Member Vars
     */
    protected $session;
    protected $loginForm;

    /**
     * Constructor
     */
    public function __construct(SessionInterface $session, LoginForm $loginForm) 
    {
        $this->session = $session;
        $this->loginForm = $loginForm;
    }

    /**
     * Show the login form
     */
    public function create(){}

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() { 
        // Form Processing
        $result = $this->loginForm->save(Input::all());
       
        if (isset($result['success']) && isset($result['data']) && $result['success']) {
            Event::fire('session.login', array(
                'userId' => $result['data']['userId'],
                'email' => $result['data']['email']
            ));
            // Success!
            return Redirect::route('base.index.index');
        } elseif (count($this->loginForm->errors()) > 0) {
            return Redirect::route('session.create')->withInput()->withErrors(array('error' => trans('session.invalid')));
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('session.create')->withInput()->withErrors(array('error' => $result['message']));
        }
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
        return Redirect::to('/');
    }

}
