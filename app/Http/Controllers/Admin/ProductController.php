<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Session, Redirect, Response, DB, Config, Auth;
use App\Models\{User, Product};
use DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
	{
    $data['title'] ="ALL Product";
    
    if ($request->ajax()) {    
         $query = Product::query();
         if ($request->get('start_date')) {
         	//print_r($request->get('start_date'));
        $query->whereDate('products.created_at', '>=', date("Y-m-d", strtotime($request->get('start_date'))));
      }
      if ($request->get('end_date')) {
        $query->whereDate('products.created_at', '<=', date("Y-m-d", strtotime($request->get('end_date'))));
      }
         return datatables()->of($query->orderBy('id', 'desc'))
         ->addIndexColumn()  
         ->editColumn('status','admin.datatable.status.product-status')
         ->editColumn('action','admin.datatable.action.product-action')
         ->rawColumns(['action','status'])
         ->make(true);
        }
    return view('admin.product.list',$data);
	}

	public function create(Request $request){
        $data["title"]="NEW";
		
		return view('admin.product.add',$data);
	}

	 public function store(Request $request)
  {
    //dd($request->all());
    $request->validate([
      'product_name'              => 'required',
      'quantity'           => 'required',
      'price'         => 'required',
    ]);

    $product_data = [
      'product_name'            => $request->get('product_name'),
      'quantity'                => $request->get('quantity'),
      'price'                   => $request->get('price'),
      'discount'               => $request->get('discount'),
      'description'               => $request->get('description'),
      'status'                 => ($request->get('status') == 1) ? ('1') : ('0'),
      'created_at'              => date('Y-m-d H:i:s'),
    ];
    $last_insert_id = Product::insertGetId($product_data);

    
    if($last_insert_id) {
      return Redirect::to("admin/products")->withSuccess("Great! Info has been added");
    } else {
      return Redirect::to("admin/products/create")->withWarning("Oops! Something went wrong");
    }
  }
}
