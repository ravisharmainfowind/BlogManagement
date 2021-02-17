<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Session, Redirect, Response, File,DB, Config, Auth;
use App\Models\{User, Category,Post_Category,Post};
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
	{
    $data['title'] ="All Category";
    
    if ($request->ajax()) {    
         $query = Category::query();
         if ($request->get('start_date')) {
        $query->whereDate('categories.created_at', '>=', date("Y-m-d", strtotime($request->get('start_date'))));
      }
      if ($request->get('end_date')) {
        $query->whereDate('categories.created_at', '<=', date("Y-m-d", strtotime($request->get('end_date'))));
      }
         return datatables()->of($query->orderBy('id', 'desc'))
         ->addIndexColumn()  
         ->editColumn('status','admin.datatable.status.category-status')
         ->editColumn('action','admin.datatable.action.category-action')
         ->rawColumns(['action','status'])
         ->make(true);
        }
    return view('admin.category.list',$data);
	}

	public function create(Request $request){
        $data["title"]="NEW";
        $data['category_info'] = Category::where('parent_id', 0)->get();		
		return view('admin.category.add',$data);
    }
    
    public function store(Request $request)
    {
      //dd($request->all());
      $request->validate([
        'name'              => 'required',
      ]);
    
      if($request->get('parent_id')){
          $parentId = $request->get('parent_id');
      }  
      else{
          $parentId = 0;
      }

      $category_data = [
        'name'            => $request->get('name'),
        'parent_id'       => $parentId,
        'status'          => ($request->get('status') == 1) ? ('1') : ('0'),
        'created_at'      => date('Y-m-d H:i:s'),
      ];
      $last_insert_id = Category::insertGetId($category_data);
      
      if($last_insert_id) {
        return Redirect::to("admin/categories")->withSuccess("Great! Info has been added");
      } else {
        return Redirect::to("admin/categories/create")->withWarning("Oops! Something went wrong");
      }
    }

    public function edit(Request $request, $id)
	{
	  $data['title'] ='edit category';
      $data['category_info'] = Category::where('id', $id)->first();
      $data['category_parent_info'] = Category::where('parent_id', 0)->get();
	  return view('admin.category.edit', $data);  
    }
    
    public function update(Request $request)
    {
      $id = $request->get('id'); 
      $request->validate([
        'name'              => 'required',
        ]
      );
      $data['category_info'] =$category_info =Category::where('id', $id)->first();

      if($request->get('parent_id')){
         $parentId = $request->get('parent_id');
      }  
      else{
         $parentId = $category_info->parent_id;
      }
    
      $category_data = [
        'name'            => $request->get('name'),
        'parent_id'       => $parentId,
        'status'          => ($request->get('status') == 1) ? ('1') : ('0'),
        'updated_at'      => date('Y-m-d H:i:s'),
      ];
      
      $update_data = Category::where('id', $id)->update($category_data);
  
      if($update_data) {
        return Redirect::to("admin/categories")->withSuccess("Great! Info has been updated");
      } else {
        return Redirect::to("admin/categories/".$id."/edit")->withWarning("Oops! Something went wrong");
      }
    }
}
