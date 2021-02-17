<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\BaseController;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role_User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Post_Category;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Auth;
use Hash;
use Response;
use Session;
use DB;
use Route;
use Image;
use URL;
use Mail;
use Redirect;

class AuthController extends BaseController
{
  public function register()
  {
    return view('auth.register');
  }

  public function storeUser(Request $request)
  {
    $request->validate([
      'name'              => 'required',
      'email'             => 'required|email|unique:users,email',
      'mobile_number'     => 'required|min:8|max:15|unique:users,mobile_number',
      'password'          => 'required|min:6',
      'confirm_password'  => 'required|min:6|same:password',
      'role_type'            => 'required',
      'status'            => 'required',
    ]);

    $user_data = [
     
      'name'          => $request->get('name'),
      'email'         => $request->get('email'),
      'mobile_number' => $request->get('mobile_number'),
      'password'      => bcrypt($request->get('password')),
      // 'birth_date'    => date('Y-m-d', strtotime($request->get('birth_date'))),
      'role_id'        => $request->get('role_type'),
      'status'        => $request->get('status'),
      'created_by'    => 0,
      'created_at'    => date('Y-m-d H:i:s'),
    ];

    if($request->hasFile('profile_picture'))
    {
        $main_image = '';
        //$image_thumb = '';
        if (!empty($id)) {
            $getData = User::where('id', $id)->first(array('profile_picture'));
            $main_image = $getData->profile_picture;
            //$image_thumb = $getData->image_thumb;
        }
        $imageResult = storeImageWithThumb(@$request->file('profile_picture'), 'users', 'avatars', $main_image);

        $user_data['profile_picture'] = $imageResult['path'];
        //$user_data['image_thumb'] = $imageResult['thumbnail'];
    }

    $last_insert_id = User::insertGetId($user_data);
    
    if($last_insert_id && $request->get('role_type') ){
      $user_role_data = [
        'role_id'       => $request->get('role_type'),
        'user_id'       => $last_insert_id,
        'created_at'    => date('Y-m-d H:i:s'),
      ];  
      $last_insert_id_data = Role_User::insertGetId($user_role_data);  
    }

    if($last_insert_id) {
      $data['user_info']= $user_info = User::where('id',$last_insert_id)->first();
      $email = $user_info['email'];
      $name = $user_info['name'];
      $id = $user_info['id'];
      $user = [
       'email'  => $email,
       'name'   => $name,
       'id'     => $id,
       'token'  => sha1(time())
     ]; 
    Mail::to($user['email'])->send(new \App\Mail\Email($user));
     //return $user;
    return Redirect::to("login")->withSuccess("Great! Registration Successfully. Please check your registered email for email verification");
      //return redirect('login');
    } else {
      return redirect('register')->withInput(Input::except('password'))->withWarning("Oops! Something went wrong");
    }
  }

  public function index()
  {
    return view('auth.login');
  }

  public function authenticate(Request $request) {
    if ($request->ajax()){       
      $user = $request->all();
      $checkUser = User::where([
      'email' => $request->get('email'),
      // 'password' => bcrypt($request->get('password'))
    ])->first();
    if($checkUser){
      $check_pass = Hash::check($request->get('password'), $checkUser->password);	
      if (!$check_pass) {
        return $this->sendError('Oops! You have entered incorrect login credentials', 401);
      }
      //$type=$checkUser->role_id;
      $type = $checkUser->roles[0]['id'];
      if(!$checkUser->email_verified_at){
        Auth::guard('web')->logout();
        return $this->sendError('Please Check Your Email For Activation Link',401);
       }
      if($checkUser->role_id==2){
        $data = User::find($checkUser->id);
      }
      if($checkUser->role_id==3){
        $data = User::find($checkUser->id);
      }
      if (($type == 2) || ($type == 3)) {
        if ($checkUser->status == '1') {
          $message = "Login successfully";
        } else {
          return $this->sendError('Oops! Your account is inactive now, please contact to administrator', 401);
        }
      } else {
      //event(new UserEvent($data));
      return $this->sendError('Oops! You have entered incorrect login credentials', 401);
        $message = "Registered successfully";
      }
      return $this->sendResponse($message,$data);
    }
    else{
      return $this->sendError('Oops! You have entered incorrect login credentials', 401);
      }
      }
    }

public function setSession(Request $request) {      
  if ($request->ajax()){
    $segment = $request->segment('1');
    $userSession = array('user' => $request->all());
    //Session::put($userSession);
    $request->session()->put($userSession);
    $res['success'] = true;
    $cookie = json_encode([
    'full_name' => $request->full_name,
          'created_by' => $request->created_by,
    'email' => $request->email,
    'password' => $request->password,
    'remember_me' => $request->remember_me,
    'mobile_number' => $request->mobile_number,
  ]);
  return Response::json($res)->cookie('admin', $cookie, 60);
}
}
  public function logout() {
    Auth::logout();
    Session::flush();
    return redirect('login');
  }

  public function home(Request $request)
  {
    $id = $request->category_id;
    $categoryId = decode($request->category);
    $postedId = decode($request->posted_by);
    $postOrder = $request->sort_by;
  
    $categoryIds = decode($id);

      if($categoryId && $postedId && $postOrder){
        $data['posts']=$posts = Post::where([
          'posted_by' => $postedId,
          ])->whereHas('categories', function ($query) use($categoryId) {
            $query->where('post_categories.category_id', $categoryId);
            })->orderBy('created_at', $postOrder)->paginate(6);     
      }elseif($categoryId && $postedId){
        $data['posts']=$posts = Post::where([
          'posted_by' => $postedId,
          ])->whereHas('categories', function ($query) use($categoryId) {
            $query->where('post_categories.category_id', $categoryId);
            })->paginate(6);
      }elseif($postedId && $postOrder){
        $data['posts'] = Post::where([
          'posted_by' => $postedId,
          ])->orderBy('created_at', $postOrder)->paginate(6);
      }elseif($categoryId && $postOrder){
        $data['posts']=$posts = Post::whereHas('categories', function ($query) use($categoryId) {
            $query->where('post_categories.category_id', $categoryId);
            })->orderBy('created_at', $postOrder)->paginate(6);
      }elseif($postedId){
        $data['posts'] = Post::where([
          'posted_by' => $postedId,
          ])->paginate(6);
      }elseif($postOrder){
        $data['posts'] = Post::orderBy('created_at', $postOrder)->paginate(6);
      }elseif($categoryId){
        $data['posts'] = Post::whereHas('categories', function ($query) use($categoryId) {
          $query->where('post_categories.category_id', $categoryId);
          })->paginate(6);
      }elseif($categoryIds){
        $data['posts']= $posts = Post::whereHas('categories', function ($query) use($categoryIds) {
         $query->where('post_categories.category_id', $categoryIds);
         })->paginate(6);
        }
      else{
        $data['posts'] = Post::where('status','=',1)->paginate(6); 
      }     
    //$data['categories']= $categories = Category::where('status','=',1)->get();
    $data['categories']=$categories = Category::where([ ['status','=',1],['parent_id','=',0]])->with('children')->get();
    $data['users']= $users = User::where([['role_id', '=', 2],['status', '=', 1]])->get();
    //User::orderBy('created_at', 'DESC')->get();
    return view('home',$data);
  }

  public function verifyUser($id)
  {
     $verifyUser = User::where('id', $id)->first();
     if(isset($verifyUser) ){
       $user = $verifyUser;
         if(!$user->email_verified_at) {
         $user->email_verified_at = date('Y-m-d H:i:s');
         $user->save();
         $status = "Your e-mail is verified. You can now login.";
         } else {
         $status = "Your e-mail is already verified. You can now login.";
       }
     } else {
    return redirect('login')->with('warning', "Sorry your email cannot be identified.");
     }
      return redirect('login')->with('success', $status);
   }
   public function postDetaile(Request $request,$id){
    $data['post_info'] = Post::where('id', decode($id))->first();
	  return view('post-details', $data);
   }
}