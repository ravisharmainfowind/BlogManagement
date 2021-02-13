<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Session, Redirect, Response, File,DB, Config, Auth;
use App\Models\{User, Category,Post_Category,Post};
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use DataTables;

class PostController extends Controller
{
    public function index(Request $request)
	{
    $data['title'] ="All Post";
    
    if ($request->ajax()) {    
         $query = Post::query();
         if ($request->get('start_date')) {
        $query->whereDate('posts.created_at', '>=', date("Y-m-d", strtotime($request->get('start_date'))));
      }
      if ($request->get('end_date')) {
        $query->whereDate('posts.created_at', '<=', date("Y-m-d", strtotime($request->get('end_date'))));
      }
         return datatables()->of($query->orderBy('id', 'desc'))
         ->addIndexColumn()
         ->editColumn('feature_image', 'admin.datatable.image.post-image')  
         ->editColumn('status','admin.datatable.status.post-status')
         ->editColumn('action','admin.datatable.action.post-action')
         ->rawColumns(['action','status','feature_image'])
         ->make(true);
        }
    return view('admin.post.list',$data);
	}

	public function create(Request $request){
        $data["title"]="NEW";
        $data['category_info'] = Category::where('status', 1)->get();		
		return view('admin.post.add',$data);
    }

    public function store(Request $request)
    {
      //dd($request->all());
      $request->validate([
        'title'              => 'required',
        'category'           => 'required',
        'publish_date'       => 'required',
        'feature_image'      => 'required|mimes:png,jpeg,gif',
      ]);
      
      $categories            = $request->get('category');

      $post_data = [
        'title'                  => $request->get('title'),
       // 'category'               => $request->get('category'),
        'publish_date'           => date('Y-m-d', strtotime($request->get('publish_date'))),
        'description'            => $request->get('description'),
        'posted_by'             => auth()->user()->id,
        'status'                 => ($request->get('status') == 1) ? ('1') : ('0'),
        'created_at'             => date('Y-m-d H:i:s'),
      ];
      if($request->hasFile('feature_image'))
    {
        $main_image = '';
        $imageResult = storeImageWithThumb(@$request->file('feature_image'), 'feature_image', 'avatars', $main_image);
        $post_data['feature_image'] = $imageResult['path'];
    }
      $last_insert_id = Post::insertGetId($post_data);
     
      foreach($categories as $key => $cat)
      {
          $post_cat = [
            'category_id' => $cat,
            'post_id'    => $last_insert_id,
            'created_at' => date('Y-m-d H:i:s'),

          ];
          
          $result = Post_Category::insertGetId($post_cat);
      
      }

      if($last_insert_id) {
        return Redirect::to("admin/posts")->withSuccess("Great! Info has been added");
      } else {
        return Redirect::to("admin/posts/create")->withWarning("Oops! Something went wrong");
      }
    }
    public function edit(Request $request, $id)
	{
		$data['title'] ='Edit Post';
    $data['category_info'] = Category::where('status', 1)->get();
    $data['post_category_info'] = Post_Category::where('post_id', $id)->get();
	  $data['post_info'] = Post::where('id', $id)->with(['postCategories'])->first();
	  return view('admin.post.edit', $data);  
	}
}
