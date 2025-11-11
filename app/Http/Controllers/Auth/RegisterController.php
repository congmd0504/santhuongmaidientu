<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        // $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Kiểm tra nếu có trường code được cung cấp thì kiểm tra xem nó tồn tại trong bảng users
        if (isset($data['code'])) {
            $rules['code'] = ['sometimes', Rule::exists('users', 'username')];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $userParent = User::where([
            'username' => $data['code'],
            ['active', '<>', 0],
        ])->first();
        // dd($userParent);

        if ($userParent) {
            $parentKey = "|" . $userParent->id . "|";
            if ($userParent->parent_all_key) {
                $parentKey = $userParent->parent_all_key . $userParent->id . "|";
            }
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                "parent_id" => $userParent->id,
                'phone' => $data['phone'] ?? '',
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'active' => 1,
                "parent_all_key" => $parentKey,
                "code" => makeCodeUser(new User()),
            ]);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? '',
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'active' => 1,
                "code" => makeCodeUser(new User()),
            ]);
        }
        $user->points()->create([
            'type' => config("point.typePoint")[31]['type'],
            'point' => configCreateUser() * getConfigBB(),
            'active' => 1,
            'userorigin_id' => $user->id,
        ]);

        return $user;
    }


    // show register for admin
    // public function showAdminRegisterForm()
    // {
    //     return view('auth.register', ['url' => 'admin']);
    // }

    // protected function createAdmin(Request $request)
    // {
    //     $this->validator($request->all())->validate();
    //     $admin = Admin::create([
    //         'name' => $request['name'],
    //         'email' => $request['email'],
    //         'password' => Hash::make($request['password']),
    //         'active'=>1,
    //     ]);
    //     return redirect()->intended('login/admin');
    // }

}
