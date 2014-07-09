<?php
namespace App\Controllers;

use \Controller,
    \Event,
    \Input,
    \Response;
    
use Users\User\UserInterface;
use Users\Form\Register\RegisterForm;
use Users\Form\Update\UpdateForm;

class UserController extends Controller{

    protected $user;
    protected $registerForm;
    protected $updateForm;
   
    public function __construct(UserInterface $user, RegisterForm $registerForm, UpdateForm $updateForm) 
    {
        $this->user = $user;
        $this->registerForm = $registerForm;
        $this->updateForm = $updateForm;
    }

    /**
     * Display a list of users.
     *
     * @return json
     */
    public function index() 
    {
        $users = $this->user->all();
        return Response::json($users, 200
        );
    }

    
    /**
     * Register an user.
     *
     * @return json
     */
    public function register() 
    {
        $isValid = $this->registerForm->valid(Input::only('fullname','email','username','password','password_confirmation'));
        if($isValid){
            $result = $this->user->register($this->registerForm->data());
            if (isset($result['user']) && ($result['success'] > 0)) {
                if ($result['logged'] > 0) {
                    Event::fire('user.register', array('data'=>$result['user']));
                }
                else{
                    Event::fire('user.mail.register', array('data'=>$result['user']));
                }
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
     * Activate a new user
     * 
     * @param  int $id   
     * @param  string $code
     *  
     * @return Response
     */
    public function activate($id, $code) 
    {
        $result = $this->user->activate($id, $code);
        if ($result['success'] > 0) {
            $this->user->login($result['user'], false);
            return \Redirect::route('home');
        } 
        return Response::make('Not Found', 404);
    }
    
    /**
     * Create an user.
     *
     * @return json
     */
    public function create() 
    {
       $isValid = $this->updateForm->valid(Input::only('fullname','email','username','password','password_confirmation','groups'));
       if($isValid){
            $result = $this->user->create($this->updateForm->data());
            if (isset($result['user']) && ($result['success'] > 0)) {
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
                'errors' => $this->updateForm->errors()),
                200
        );
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return json
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
     * Update the user.
     *
     * @param  int  $id
     * 
     * @return json
     */
    public function account($id) 
    {
        $isValid = $this->updateForm->valid(Input::only('fullname', 'email', 'username'));
        if ($isValid) {
            $result = $this->user->account($id,$this->updateForm->data());
            if (isset($result['user']) && ($result['success'] > 0)) {
                return Response::json($result,200);
            } 
            $error = isset($result['error'])?array_pop($result):trans('user.generror');
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        }
        return Response::json(array(
                    'success' => 0,
                    'errors' => $this->updateForm->errors()), 
                    200
        );
    }
    
    /**
     * Update the user.
     *
     * @param  int  $id
     * 
     * @return json
     */
    public function password($id) 
    {
        $isValid = $this->updateForm->valid(Input::only('old_password' ,'password','password_confirmation'));
        if ($isValid) {
            $result = $this->user->password($id,$this->updateForm->data());
            if (isset($result['user']) && ($result['success'] > 0)) {
                return Response::json($result,200);
            } 
            $error = isset($result['error'])?array_pop($result):trans('user.generror');
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        }
        return Response::json(array(
                    'success' => 0,
                    'errors' => $this->updateForm->errors()), 
                    200
        );
    }
    
    /**
     * Update the user.
     *
     * @param  int  $id
     * 
     * @return json
     */
    public function edit($id) 
    {
        $isValid = $this->updateForm->valid(Input::only('fullname', 'email', 'username','groups'));
        if ($isValid) {
            $result = $this->user->edit($id,$this->updateForm->data());
            if (isset($result['user']) && ($result['success'] > 0)) {
                return Response::json($result,200);
            } 
            $error = isset($result['error'])?array_pop($result):trans('user.generror');
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        }
        return Response::json(array(
                    'success' => 0,
                    'errors' => $this->updateForm->errors()), 
                    200
        );
    }

    /**
     * Suspend user
     * 
     * @param  int $id 
     * 
     * @return json     
     */
    public function suspend($id) 
    {
        $isValid = $this->updateForm->valid(Input::only('minutes'));
        if ($isValid) {
            $result = $this->user->suspend($id,$this->updateForm->data());
            if ($result['success'] > 0) {
                return Response::json($result,200);
            } 
            $error = isset($result['error'])?array_pop($result):trans('user.generror');
            return Response::json(array(
              'success'=>0,
              'errors' => array('error'=>array($error))),  
            200);
        }
        return Response::json(array(
                    'success' => 0,
                    'errors' => $this->updateForm->errors()), 
                    200
        );
    }
    
    /**
     * Unsuspend user
     * 
     * @param  int $id 
     * 
     * @return json     
     */
    public function unsuspend($id) 
    {
        $result = $this->user->unSuspend($id);
        if ($result['success'] > 0) {
            return Response::json($result,200);
        } 
        return Response::make('Not Found', 404);
    }
    
    /**
     * Ban an user
     * 
     * @param  int $id 
     * 
     * @return Redirect     
     */
    public function ban($id) 
    {
        $result = $this->user->ban($id);
        if ($result['success'] > 0) {
            return Response::json($result,200);
        } 
        return Response::make('Not Found', 404);
    }

    /**
     * Unban an user
     * 
     * @param  int $id 
     * 
     * @return Redirect     
     */
    public function unban($id) 
    {
        $result = $this->user->unBan($id);
        if ($result['success'] > 0) {
            return Response::json($result,200);
        } 
        return Response::make('Not Found', 404);
    }

    /**
     * Remove the user.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function destroy($id) {
        if ($this->user->destroy($id)) {
             return Response::make('OK', 200); 
        } 
        return Response::make('Internal Server Error', 500); 
    }

 }

