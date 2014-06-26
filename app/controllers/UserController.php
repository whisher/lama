<?php
namespace App\Controllers;

use \Controller,
    \Event,
    \Input,
    \Response;
    
use Users\User\UserInterface;
use Users\Form\Register\RegisterForm;

class UserController extends Controller{

    protected $user;
    protected $registerForm;
    
   
    public function __construct(UserInterface $user, RegisterForm $registerForm) 
    {
        $this->user = $user;
        $this->registerForm = $registerForm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() 
    {
        $users = $this->user->all();
        return Response::json(array(
                    'data' => $users), 200
        );
    }

    /**
     * Store a newly created user.
     *
     * @return json
     */
    public function store() 
    {
        $isValid = $this->registerForm->valid(Input::only('fullname','email','username','password','password_confirmation'));
        if($isValid){
            $result = $this->user->store($this->registerForm->data());
            if (isset($result['user']) && $result['success']) {
                Event::fire('user.register', $result['user']);
                return Response::json($result,200);
            } 
            $error = isset($result['error'])?array_pop($result):trans('user.generror');
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        }
        return Response::json(array(
                'success'=>0,
                'errors' => $this->registerForm->errors()),
                200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) 
    {
        $user = $this->user->byId($id);
        if(!$user){
           return Response::make('Not Found', 404);
        }
        return Response::json($user->toArray(),  
            200); 
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        // Form Processing
        $result = $this->userForm->update(Input::all());

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('UserController@show', array($id));
        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@edit', array($id))
                            ->withInput()
                            ->withErrors($this->userForm->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        if ($this->user->destroy($id)) {
            Session::flash('success', 'User Deleted');
            return Redirect::to('/users');
        } else {
            Session::flash('error', 'Unable to Delete User');
            return Redirect::to('/users');
        }
    }

    /**
     * Activate a new user
     * @param  int $id   
     * @param  string $code 
     * @return Response
     */
    public function activate($id, $code) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->activate($id, $code);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
    }

    /**
     * Process resend activation request
     * @return Response
     */
    public function resend() {
        // Form Processing
        $result = $this->resendActivationForm->resend(Input::all());

        if ($result['success']) {
            Event::fire('user.resend', array(
                'email' => $result['mailData']['email'],
                'userId' => $result['mailData']['userId'],
                'activationCode' => $result['mailData']['activationCode']
            ));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('profile')
                            ->withInput()
                            ->withErrors($this->resendActivationForm->errors());
        }
    }

    /**
     * Process Forgot Password request
     * @return Response
     */
    public function forgot() {
        // Form Processing
        $result = $this->forgotPasswordForm->forgot(Input::all());

        if ($result['success']) {
            Event::fire('user.forgot', array(
                'email' => $result['mailData']['email'],
                'userId' => $result['mailData']['userId'],
                'resetCode' => $result['mailData']['resetCode']
            ));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('forgotPasswordForm')
                            ->withInput()
                            ->withErrors($this->forgotPasswordForm->errors());
        }
    }

    /**
     * Process a password reset request link
     * @param  [type] $id   [description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function reset($id, $code) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->resetPassword($id, $code);

        if ($result['success']) {
            Event::fire('user.newpassword', array(
                'email' => $result['mailData']['email'],
                'newPassword' => $result['mailData']['newPassword']
            ));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
    }

    /**
     * Process a password change request
     * @param  int $id 
     * @return redirect     
     */
    public function change($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $data = Input::all();
        $data['id'] = $id;

        // Form Processing
        $result = $this->changePasswordForm->change($data);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@edit', array($id))
                            ->withInput()
                            ->withErrors($this->changePasswordForm->errors());
        }
    }

    /**
     * Process a suspend user request
     * @param  int $id 
     * @return Redirect     
     */
    public function suspend($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        // Form Processing
        $result = $this->suspendUserForm->suspend(Input::all());

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@suspend', array($id))
                            ->withInput()
                            ->withErrors($this->suspendUserForm->errors());
        }
    }

    /**
     * Unsuspend user
     * @param  int $id 
     * @return Redirect     
     */
    public function unsuspend($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->unSuspend($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
    }

    /**
     * Ban a user
     * @param  int $id 
     * @return Redirect     
     */
    public function ban($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->ban($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
    }

    public function unban($id) {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->unBan($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
    }

}

