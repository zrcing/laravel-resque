<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
//use App\Http\Requests\Request;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'task.html';
    
    protected $redirectAfterLogout = 'auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Except getLogout function 
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => ':attribute 不能为空',
            'required' => ':attribute 不能为空'
        ];
        
        //自定义attribute 名称
        $attributes = [
            'name' => '用户名',
            'email' => '邮箱'
        ];
        
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            //'password' => 'required|confirmed|min:6',
            'password' => 'required|min:6',
        ], $messages)
        ->setAttributeNames($attributes);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request)
    {
        //$errors = $request->session()->get('errors'); or $errors = session('errors');
        //获取上一次$oldInputs = $request->session()->getOldInput(); or  $oldInputs = session('_old_input');
        
        return $this->showRegistrationForm();
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        /*
        //方法一
        $validator = $this->validator($request->all());
    
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }
    
        Auth::login($this->create($request->all()));
    
        return redirect($this->redirectPath());
        */
        //方法二
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return redirect('auth/register')
                    ->withErrors($validator)
                    ->withInput();
        }
        Auth::login($this->create($request->all()));
        
        return redirect($this->redirectPath());
        
        /* 方法三
         $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            //'password' => 'required|confirmed|min:6',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect('auth/register')
                    ->withErrors($validator);
        }
        Auth::login($this->create($request->all()));
        
        return redirect($this->redirectPath());
         * 
         */
    }
    
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password')])) {
            // Authentication passed...
            //return redirect()->intended('dashboard');
            return redirect($this->redirectTo);
        }
        
        return redirect('auth/login')
        ->with('error', trans("front/login.login-failure"));
    }
}
