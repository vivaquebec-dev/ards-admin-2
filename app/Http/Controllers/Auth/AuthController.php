<?php



namespace App\Http\Controllers\Auth;



use App\User;
use App\Licence;

use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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



    protected $redirectPath = '/';



    /**

     * Create a new authentication controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest', ['except' => 'getLogout']);

    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 
            'password' => 'required',
            'optin' => 'required',
        ], [
            'optin.required' => 'Vous devez cocher la case pour indiquer que vous avez lu et accepté les conditions d\'utilisation et la politique de confidentialité.',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if ($this->hasExpiredLicence(Auth::user())) {
                Auth::logout();

                return redirect($this->loginPath())
                    ->withInput($request->only($this->loginUsername(), 'remember'))
                    ->withErrors([
                        $this->loginUsername() => 'Votre licence est expirée.',
                    ]);
            }

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function hasExpiredLicence(User $user)
    {
        if (!in_array((int) $user->id_type_usager, [3, 4, 5])) {
            return false;
        }

        $licence = Licence::find($user->id_licence);

        if (!$licence || empty($licence->date_expiration_licence) || $licence->date_expiration_licence == '0000-00-00') {
            return true;
        }

        return $licence->date_expiration_licence <= date('Y-m-d');
    }

    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

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
            'nom' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}

