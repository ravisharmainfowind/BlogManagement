<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Session, Redirect, Response, DB, Config, File, Mail, Auth;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use App\Models\{User,Role,Role_User,Product};

class AuthController extends Controller
{
    public function dashboard(Request $request)
    {
        //return redirect('admin/users');
        $data['title'] = "Dashboard";
        //$data['product_info'] = Product::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.dashboard',$data);
    }

    public function login(Request $request)
    {   
    	$data['title'] = __('message.LOGIN_HERE');

        return view("admin.auth.login", $data);
    }

    public function postLogin(Request $request)
    {
    	$credentials = $request->validate([
    			'email' => 'required|email|string|max:255',
    			'password' => 'required|min:6'
    		]);
    	if (auth('web')->attempt($credentials)) {
            $user = auth('web')->user();
            
            foreach ($user->roles as $role) {
               $ids[] = $role->id;  
            }
            // $length = count($ids);
            // print_r($ids);die;
            $user_id = $user->roles[0]['id'];
    
            if($user_id == '1')
            {
                return redirect()->intended('admin/dashboard');
            }elseif($user_id == '2'){
                return redirect()->intended('admin/dashboard');
            }elseif($user_id == '3'){
                return redirect()->intended('admin/dashboard');
            }
            else
            {
                Auth::guard('web')->logout();
                return redirect('admin/login')->withInput()->withWarnings([
                    'error' => 'THIS IS NOT VALID USER'
                ]);
            }
        }
        return redirect('admin/login')->withInput()->withWarnings(['error' => 'INVALID CREADENTIALS']);
    }

    /* For Get Forget Password Form */
    public function getForgotPasswordForm()
    {
    	$data['title'] = __('message.FORGET_PASSWORD');

    	return view('admin.auth.forget-password', $data);
    }

    /* For Get Token Link For Take New Password Form */
    public function getForgetPasswordToken(Request $request)
    {
    	$data = $request->validate([
    			'email' => 'required|email|string|max:255'
    		]);

    	$is_exists = User::where('email', $data['email'])->first();
    	if($is_exists)
    	{
    		$data['email'] = $request->email;
            $name = $is_exists->name;
            $token = "?token=".encrypt($is_exists->id);
            $token = url('admin/reset-forgot-password'.$token);

            Mail::send('emails.admin-forgot', ['token' => $token, 'name' => $name], function ($message) use($data) {
                    $message->to($data['email'], '')->subject(__('message.CREATE_NEW_PASSWORD'));
                });
            return redirect('admin/forget-password')->withSuccess(__('message.WE_SENT_LINK_REGISTERED_EMAIL'));
        } 
        else 
        {
            return Redirect::to("admin/forget-password")->withFail(__('message.EMAIL_NOT_REGISTERED'))->withInput();
        }
    }

    /* For Get New Password Form*/
    public function getNewPasswordForm(Request $request) 
    {
        $data['title'] = "Reset Forgot Password";
        $data['id'] = decrypt($request->get('token'));

        $checkData = User::where('id', $data['id'])->first();
        
        if(!empty($checkData))
        {
            $data['id'] = encode($data['id']);
            return view("admin.auth.change-password", $data);
        }

        return redirect('admin/login');
        
    }

    /* For Update New Password */
    public function updateNewPassword(Request $request)
    {
    	$data = $request->validate([
    				'password' => 'required|max:20|min:6',
                    'confirm_password' => 'required|same:password',
    			]);
    	$id = decode($request->id);
    	$password = array('password' => bcrypt($request->password));

    	$update = User::where('id', $id)->update($password);
    	if ($update) 
    	{
            return Redirect::to("admin/login")->withSuccess("New Password create successfully");
        } 
        else 
        {
            return Redirect::to("admin/reset-forgot-password")->withWarnings("Something went wrong please try again");
        }
    }
    public function logout(){
        
        Auth::guard('web')->logout();

        return redirect('admin/login');
    }
    public function changePasswordProfile(){
        
       return view("admin.auth.admin-change-password-profile");
    }
    public function updatePassword(Request $request)
    {  


        $data = $request->validate([
            'old_password' => 'required',            
            'new_password' => 'required',  
            'c_password' => 'required|same:new_password',  
          ]);

        if (\Hash::check($request->old_password, $request->user()->password)) { 
            $updateArr['password'] = bcrypt($request->new_password);
            $where = ['id' => $request->user()->id, 'role_id' => 1];

            $update = User::where($where)->update($updateArr);
           
           if( $update ){
             return Redirect::to("admin/profile")->withSuccess("New Password create successfully");
           }
        }else{
            return Redirect::to("admin/profile")->withSuccess("Old password does not match");
        }
        return Response::error('Something goes to wrong. Please try again');
    }    
    public function updateProfile(Request $request)
    {  
        $id = auth()->user()->id;
        $data = $request->validate([
            'name'          => 'required',
            'mobile_number' => 'required|min:8|max:15|unique:users,mobile_number,' .$id,
            'email'         => 'required|email|unique:users,email,' .$id,
          ]);

            $updateArr['name']          = $request->name;
            $updateArr['email']         = $request->email;
            $updateArr['mobile_number'] = $request->mobile_number;
            $updateArr['updated_at']    = date('Y-m-d H:i"s');

            $where = ['id' => $request->user()->id, 'role_id' => 1];

            $update = User::where($where)->update($updateArr);
           
           if( $update ){
             return Redirect::to("admin/profile")->withSuccess("Profile has been updated successfully");
           }
         else{
            return Redirect::to("admin/profile")->withSuccess("Profile is not update.");
        }
        return Response::error('Something goes to wrong. Please try again');
    } 
}
