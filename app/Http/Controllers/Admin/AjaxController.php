<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Session, Redirect, Response, DB, Config, File, Mail, Auth;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use App\Models\User;

class AjaxController extends Controller
{
    public function mksCheckMobile(Request $request)
    {
        $id = $request->get('id');
        $mobile_number = $request->get('mobile_number');
        $query = User::query();
        $query->where(array('mobile_number' => $mobile_number));
        
        if($id){
            $query->where('id','!=',$id);     
        }
        $result = $query->first();
        if($result){
            return "false";
        }else{
            return "true";
        }
    }

    public function mksCheckEmail(Request $request)
    {
        $id = $request->get('id');
        $email = $request->get('email');
        $query = User::query();
        $query->where(array('email' => $email));
        
        if($id){
            $query->where('id','!=',$id);     
        }
        $result = $query->first();
        if($result){
            return "false";
        }else{
            return "true";
        }
    }

	public function changeStatus(Request $request) {

		$table = $request->table;
		$id = $request->id;

		$query = 'UPDATE `' . $table . '` SET `status` = IF(`status` = "1", "0", "1") WHERE `id` = "' . $id . '"';
		$result = DB::update($query);
		if ($result) {
			die('1');
		} else {
			die('0');
		}
	}
 
	public function hardDelete(Request $request) {
		//dd($request->get('id'));die;
        $table = $request->get('table');
        $id = $request->get('id');
        $where = array('id' => $id);
		$result = DB::table($table)->where($where)->delete();

		if ($result) {
			die('1');
		} else {
			die('0');
		}
	}
}