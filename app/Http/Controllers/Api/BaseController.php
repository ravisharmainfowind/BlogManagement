<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Verification;

use Image;

class BaseController extends Controller {

	public function sendResponse($message, $result = "") {

		$response = [

			'success' => true,

			'message' => $message,

			'code' => 200,

		];

		if (!empty($result)) {

			$response['result'] = $result;

		}

		return response()->json($response, 200);
	}

	/*
		  * @Desc: to send error or expected operation did not happened
	*/

	public function sendError($error, $code = 404, $errorMessages = []) {

		$response = [

			'success' => false,
			'message' => $error,
			'code' => $code,
		];

		if (!empty($errorMessages)) {

			$response['data'] = $errorMessages;
		}

		return response()->json($response, $code);
	}

	public function insert_verification($user, $type) {

		$code = rand(1111, 9999);

		$data = array(

			'user_id' => $user->id,
			'code' => $code,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'deleted_at' => null,
		);

		Verification::UpdateOrCreate(['user_id' => $user->id], $data);
		return $code;
	}

	public function uploadFile($file, $type) {

		$image = "";

		if ($file && $file != "") {

			$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

		}

		if (!empty($image)) {

			switch ($type) {

			case 'profile':

				if ($file && $file != "") {

					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

					Image::make($file)->resize(200, 200)->save('public/uploads/profiles/thumbnails/' . $image);

					$file->move('public/uploads/profiles', $image);

					return $image;
				}

				break;

			case 'product_image':

				if ($file && $file != "") {

					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

					Image::make($file)->resize(200, 200)->save('public/uploads/products/thumbnails/' . $image);

					$file->move('public/uploads/products', $image);

					return $image;
				}

				break;
	

			case 'cat_image':

				if ($file && $file != "") {
                     
					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

					Image::make($file)->resize(200, 200)->save('public/uploads/category/thumbnails/' . $image);

					$file->move('public/uploads/category', $image);

					return $image;
                    
				}

				

				case 'edit_cat_image':

				if ($file && $file != "") {

					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

					Image::make($file)->resize(200, 200)->save('public/uploads/category/thumbnails/' . $image);

					$file->move('public/uploads/category', $image);

					return $image;
				}

				break;

				case 'logo_image':
                   
				if ($file && $file != "") {

					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();

					Image::make($file)->resize(200, 200)->save('public/uploads/user_brand_logo/thumbnails/' . $image);

					$file->move('public/uploads/user_brand_logo', $image);

					return $image;
				}

				break;

				case 'reference_image':

				if ($file && $file != "") {
                    
					$image = getTimeStamp() . "." . $file->getClientOriginalExtension();
                     
					 Image::make($file)->resize(200, 200)->save('public/uploads/referenceimage/thumbnails/' . $image);

					$file->move('public/uploads/referenceimage', $image);

					return $image;
				}

				break;

			default:

				$image = "";

				break;
			}
		}

		return $image;

	}
}
