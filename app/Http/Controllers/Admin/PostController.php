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
}
