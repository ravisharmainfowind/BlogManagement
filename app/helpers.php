<?php

use App\Helpers\uuid;
use App\Models\Access\User\User;
use App\Models\Notification\Notification;
use App\Models\Settings\Setting;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


/*  Mangal Solanki */

	if (!function_exists('safe_b64encode')) {
		function safe_b64encode($string) {
			$data = base64_encode($string);
			$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
			return $data;
		}
	}
	if (!function_exists('safe_b64decode')) {
		function safe_b64decode($string) {
			$data = str_replace(array('-', '_'), array('+', '/'), $string);
			$mod4 = strlen($data) % 4;
			if ($mod4) {
				$data .= substr('====', $mod4);
			}
			return base64_decode($data);
		}
	}

	if (!function_exists('encode')) {
		function encode($value) {
			$skey = 'D99p@K$uN&r@8888';
			if (!$value) {
				return false;
			}
			$text = $value;
			$crypttext = str_rot13($text . $skey);
			return trim(safe_b64encode($crypttext));
		}
	}

	if (!function_exists('decode')) {
		function decode($value) {
			$skey = 'D99p@K$uN&r@8888';
			if (!$value) {
				return false;
			}
			$crypttext = safe_b64decode($value);
			$text = str_rot13($crypttext);
			$decrypttext = str_replace($skey, "", $text);
			return trim($decrypttext);
		}
	}

	if (!function_exists('sendMessage')) {
		function sendMessage($mobile_number, $message) {
			$senderId = 'FATFOD';
			$authKey = 'a1f87d793644e36aede64cd78a1bc5d';
			$message = urlencode($message);
			$url = "http://msg.kiriinfotech.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$authKey&message=$message&senderId=$senderId&routeId=1&mobileNos=$mobile_number&smsContentType=english";
			return file_get_contents($url);
		}
	}

	if (!function_exists('storeImageWithThumb')) {
		function storeImageWithThumb($file, string $role, string $folderName, string $main_image = null, $thumb_path = null) {
			
			if ($file instanceof UploadedFile) {
				if ($main_image != '') {
					$d_file = 'public/' . $main_image;
					//$d_file = $main_image;
					File::delete($d_file);
				}
				if ($thumb_path != '') {
					$thumb_file = 'public/' . $thumb_path;
					File::delete($thumb_file);
				}

				$rand = md5(time() . mt_rand(100000000, 999999999));
				$name = $rand . "." . $file->getClientOriginalExtension();
				//$unique_path = makeUniquePath('user', 'multipleImages');
				$unique_path = makeUniquePath($role,$folderName);
				//$path = makeFolder('user', 'multipleImages', $unique_path);
				$path = makeFolder($role,$folderName, $unique_path);
				$res = $file->move($path, $name); //
				//print_r($res);die;
				//$val = storeImageWithThumb($file,'user','multipleImages', $main_image, $thumb_image);
				if ($res) {
					$val = array(
						'success' => true,
						'name' => $name,
						'mime' => $file->getClientMimeType(),
						'path' => 'storage/' . $unique_path . $name,
						'thumbnail' => 'storage/' . $unique_path . 'thumbnail/' . $name,
					);
					return $val;
				} else {
					return array(
						'success' => true,
						'message' => "File not uploaded !",
					);
				}
			} else {
				return array(
					'success' => true,
					'message' => "Not valid file format!",
				);
			}
		}
	}

	if (!function_exists('deletImageWithThumb')) {

		function deletImageWithThumb(string $role, string $folderName, string $main_image = null, $thumb_path = null) {
			if ($main_image != '') {
				$d_file = 'public/' . $main_image;
				$d = File::delete($d_file);
			}
			if ($thumb_path != '') {
				$thumb_file = 'public/' . $thumb_path;
				File::delete($thumb_file);
			}
		}
	}

	if (!function_exists('makeFolder')) {
		function makeFolder($role, $folderName, $unique_path) {
			$path = storage_path('app/public/' . $unique_path);
			File::makeDirectory($path, 0777, true, true);
			return $path;
		}
	}
	if (!function_exists('makeUniquePath')) {
		function makeUniquePath($folderName, $role) {
			$year = date('Y');
			$month = date('M');
			$unique_path = $folderName . '/';
			return $unique_path;
		}
	}

	if (!function_exists('multLanguageDateFormat')) {

	    function multLanguageDateFormat($time) {
	    	$locale = \App::getLocale();
		    if($locale == 'nl'){
		        $time = strtotime($time);
		        $months = ["Jan" => "januari", "Feb" => "februari", "Mar" => "maart", "Apr" => "april", "May" => "mei", "Jun" => "juni", "Jul" => "juli", "Aug" => "augustus", "Sep" => "september", "Oct" => "oktober", "Nov" => "november", "Dec" => "december"];
		        $month = $months[date('M', $time)];
		        $date = date('d', $time) .'-'. $month .'-'. date('Y', $time);

		        $numbers_ar = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
		        $numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

		        //return str_replace($numbers_en, $numbers_ar, $date);
		        return $date;
		    } else if($locale == 'es') {
		        $time = strtotime($time);
		        $months = ["Jan" => "enero", "Feb" => "febrero", "Mar" => "marzo", "Apr" => "abril", "May" => "mayo", "Jun" => "junio", "Jul" => "julio", "Aug" => "agosto", "Sep" => "septiembre", "Oct" => "octubre", "Nov" => "noviembre", "Dec" => "diciembre"];


		        $month = $months[date('M', $time)];
		        $date = date('d', $time) .'-'. $month .'-'. date('Y', $time);

		        $numbers_ar = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
		        $numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

		        //return str_replace($numbers_en, $numbers_ar, $date);
		        return $date;

	        } else {
	        	return date(Config::get('constants.DATE_FORMAT'), strtotime($time));
	        }
	    }
	}

	if (!function_exists('multLanguageDayName')) {
	    function multLanguageDayName($time) {
	    	$locale = \App::getLocale();
		    if($locale == 'nl'){
		    	$time = strtotime($time);
		        $days = ["Saturday" => "za", "Sunday" => "zo", "Monday" => "ma", "Tuesday" => "di", "Wednesday" => "wo", "Thursday" => "do", "Friday" => "vr"];
		        $day = $days[date('l', $time)];
		        return $day;
		    } else if($locale == 'es') {
		        $time = strtotime($time);
		        $days = ["Saturday" => "sa", "Sunday" => "do", "Monday" => "lu", "Tuesday" => "ma", "Wednesday" => "mi", "Thursday" => "ju", "Friday" => "vi"];
		        $day = $days[date('l', $time)];
		        return $day;
	        } else {
	        	$time = strtotime($time);
		        $days = ["Saturday" => "Sat", "Sunday" => "Sun", "Monday" => "Mon", "Tuesday" => "Tue", "Wednesday" => "Wed", "Thursday" => "Thu", "Friday" => "Fri"];
		        $day = $days[date('l', $time)];
		        return $day;
	        }
	    }
	}

	if (!function_exists('dayFullNme')) {
	    function dayFullNme($time) {
	    	$locale = \App::getLocale();
		    if($locale == 'nl'){
		    	$time = strtotime($time);
		        $days = ["Saturday" => "zaterdag", "Sunday" => "zondag", "Monday" => "maandag", "Tuesday" => "dinsdag", "Wednesday" => "woensdag", "Thursday" => "donderdag", "Friday" => "vrijdag"];
		        $day = $days[date('l', $time)];
		        return $day;
		    } else if($locale == 'es') {
		        $time = strtotime($time);
		        $days = ["Saturday" => "sábado", "Sunday" => "domingo", "Monday" => "lunes", "Tuesday" => "martes", "Wednesday" => "miércoles", "Thursday" => "jueves", "Friday" => "viernes"];
		        $day = $days[date('l', $time)];
		        return $day;
	        } else {
	        	$time = strtotime($time);
		        $days = ["Saturday" => "Saturday", "Sunday" => "Sunday", "Monday" => "Monday", "Tuesday" => "Tuesday", "Wednesday" => "Wednesday", "Thursday" => "Thursday", "Friday" => "Friday"];
		        $day = $days[date('l', $time)];
		        return $day;
	        }
	    }
	}

	if (!function_exists('multiLanguageTimeFormate')) {
	    function multiLanguageTimeFormate($time) {
	    	$locale = \App::getLocale();
		    if($locale == 'nl'){
		    	$time = strtotime($time);
		        $formate = ["am" => "nl-A.M.", "pm" => "el-P.M."];
		        $time_formate = $formate[date('a', $time)];
		        //dd($time_formate);
		        return $time_formate;
		    } else if($locale == 'es') {
		        $time = strtotime($time);
		        $formate = ["am" => "es-A.M.", "pm" => "es-P.M"];
		        $time_formate = $formate[date('a', $time)];
		        return $time_formate;
	        } else {
	        	$time = strtotime($time);
		        $formate = ["am" => "A.M.", "pm" => "P.M."];
		        $time_formate = $formate[date('a', $time)];
		        return $time_formate;
	        }
	    }
	}

	if (! function_exists('words')) {
	    function words($value, $words = 2, $end = '...')
	    {
	        return \Illuminate\Support\Str::words($value, $words, $end);
	    }
	}

	function send_notification_FCM($notification_id, $title, $message, $id = null, $type) {

		$accesstoken = 'AAAAzm3fz18:APA91bF1XQi8cPRMG6SGdlTlraM6lNqIKzDLtYBK9ZkmWPE9UzIKxutzI-gkwYNcuXMpSyECB6xDKx_WsxFAVy_kPVabl6EAa28ZGzSFq_7qEcL2MSlX1gfqUbD9KnKeS-WP15odW6Vc';

		$URL = 'https://fcm.googleapis.com/fcm/send';

		$post_data = '{
	        "to" : "' . $notification_id . '",
	        "data" : {
	          "body" : "",
	          "title" : "' . $title . '",
	          "type" : "' . $type . '",
	          "id" : "' . $id . '",
	          "message" : "' . $message . '",
	        },
	        "notification" : {
	             "body" : "' . $message . '",
	             "title" : "' . $title . '",
	              "type" : "' . $type . '",
	             "id" : "' . $id . '",
	             "message" : "' . $message . '",
	            "icon" : "new",
	            "sound" : "default"
	            },

	      }';

		$crl = curl_init();
		$headr = array();
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: key=' . $accesstoken;

		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($crl, CURLOPT_URL, $URL);
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
		curl_setopt($crl, CURLOPT_POST, true);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

		$rest = curl_exec($crl);

		if ($rest === false) {

			// throw new Exception('Curl error: ' . curl_error($crl));
			//print_r('Curl error: ' . curl_error($crl));
			$result_noti = 0;
		} else {

			$result_noti = 1;
		}

		//curl_close($crl);
		//print_r($result_noti);die;
		return $result_noti;
	}
