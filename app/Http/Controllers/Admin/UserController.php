<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Session, Redirect, Response, DB, Config, File, Mail, Auth;
use App\Models\{User,Role_User};
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	public function index()
	{
    //dd(auth()->user());
  	$data['title'] ="USER LIST";

  	if(request()->ajax())
  	{
      return datatables()->of(User::where('role_id',3))
        ->editColumn('users.created_at', function($data){
          return date(Config::get('constants.DATE_FORMAT'), strtotime($data->created_at));
        })
        ->editColumn('mobile_number',function($data){
          $mobile_number = 'N/A';
          if(@$data->mobile_number){
           $mobile_number = $data->mobile_number;
          }
          return $mobile_number;
      })
    //->editColumn('profile_picture', 'admin.datatable.image.user-image')
		->editColumn('status', 'admin.datatable.status.user-status')
		->addColumn('action', 'admin.datatable.action.user-action')
		->rawColumns(['status', 'action', 'created_at', 'profile_picture'])
    ->filterColumn('status', function($query, $keyword) {
        $query->whereRaw("IF(users.status=1, 'Active', 'Inactive') like ?", ["{$keyword}%"]);
      })
    ->addIndexColumn()
		->make(true);
  	}

  	return view('admin.users.list',$data);
	}

	public function create(Request $request)
	{
	  $data['title'] ='add user';
	  $data['user_info'] = array();
	  return view('admin.users.add', $data);  
	}

  public function store(Request $request)
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
      'created_by'    => auth()->user()->id,
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
      return Redirect::to("admin/users")->withSuccess("Great! Info has been added");
    } else {
      return Redirect::to("admin/users/create")->withInput(Input::except('password'))->withWarning("Oops! Something went wrong");
    }
  }

	public function edit(Request $request, $id)
	{
		$data['title'] ='edit_user';
	  $data['user_info'] = User::where('id', $id)->first();
	  return view('admin.users.edit', $data);  
	}

  public function update(Request $request)
  {
    $id = $request->get('id'); 
    $request->validate([
      'name'              => 'required',
      'email'             => 'required|email|unique:users,email,'.$id,
      'mobile_number'     => 'required|min:8|max:15|unique:users,mobile_number,'.$id,
      'role_type'            => 'required',
      ]
    );
  
    $user_data = [
      'name'              => $request->get('name'),
      'email'             => $request->get('email'),
      'mobile_number'     => $request->get('mobile_number'),
      'role_id'            => $request->get('role_type'),
      //'status'            => $request->get('status'),
      'updated_by'        => auth()->user()->id,
      'updated_at'        => date('Y-m-d H:i:s'),
    ];
    //dd($user_data);die;
    if(!empty($request->get('password'))) {
      $user_data['password'] = bcrypt($request->get('password'));
    }

    if($request->hasFile('profile_picture'))
    {
        $main_image = '';
        //$image_thumb = '';
        if (!empty($id)) {
            $getData = User::where('id', $id)->first(array('profile_picture'));
            $main_image = $getData->profile_picture;
           // $image_thumb = $getData->image_thumb;
        }
        $imageResult = storeImageWithThumb(@$request->file('profile_picture'), 'users', 'avatars', $main_image);

        $user_data['profile_picture'] = $imageResult['path'];
        //$user_data['image_thumb'] = $imageResult['thumbnail'];
    }

    $update_data = User::where('id', $id)->update($user_data);

    if($id && $request->get('role_type') ){
      $user_role_data = [
        'role_id'       => $request->get('role_type'),
        'user_id'       => $id,
        'created_at'    => date('Y-m-d H:i:s'),
      ];  
      $last_insert_id_data = Role_User::where('user_id', $id)->update($user_role_data);  
    }

    if($update_data) {
      return Redirect::to("admin/users")->withSuccess("Great! Info has been updated");
    } else {
      return Redirect::to("admin/users/".$id."/edit")->withInput(Input::except('password'))->withWarning("Oops! Something went wrong");
    }
  }

	// public function show($id)
	// {
	// 	$data['title'] = __('message.ep_details');
	//   $data['user_info'] = User::where('id', $id)->with(['area'])->first();
	//   return view('admin.users.show-details', $data);  
	// }

 //  public function userDelete(Request $request)
 //  {
 //    $id = $request->get('id');
 //    $user = User::find($id);
 //    if($user){
 //      $events_id = Event::where('user_id', $id)->get(); 
 //      if(!empty($events_id)) {
 //        foreach($events_id as $ev)
 //        {
 //          $delete_e_type = UserEventType::where('event_id', $ev->id)->delete();
 //          $delete_p_type = UserPublicType::where('event_id', $ev->id)->delete();
 //          $delete_images = EventImages::where('event_id', $ev->id)->delete();
 //          $delete_images = Event::where('id', $ev->id)->delete();
 //        }
 //      }
 //      $user->eventProvider->delete();
 //      $result = $user->delete();
 //      if ($result) {
 //        die('1');
 //      } else {
 //        die('0');
 //      }
 //    } else {
 //        die('0');
 //    }
 //  }
}