<?php

use App\Models\User;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;

function orderTodayIn()
{
    $role = auth()->user()->role;
    $total = 0;
    if ($role==11) {
      $total =  Sale::where('date',date('Y-m-d'))->get()->count();
    }else{
        $store_id = auth()->user()->store_id;
        $total =  Sale::where('date',date('Y-m-d'))
                    ->where('store_id',$store_id)
                    ->get()->count();

    }
    return $total;
}
function orderMonthIn()
{
    $role = auth()->user()->role;
    $total = 0;
    if ($role==11) {
      $total =  Sale::where('date','LIKE','%'.date('Y-m').'%')->get()->count();
    }else{
        $store_id = auth()->user()->store_id;
        $total =  Sale::where('date','LIKE','%'.date('Y-m').'%')
                    ->where('store_id',$store_id)
                    ->get()->count();

    }
    return $total;
}
function pendapatanTodayIn()
{
    $role = auth()->user()->role;
    $total = 0;
    if ($role==11) {
      $total =  Sale::where('date',date('Y-m-d'))->get()->sum('grand_total');
    }else{
        $store_id = auth()->user()->store_id;
        $total =  Sale::where('date',date('Y-m-d'))
                    ->where('store_id',$store_id)
                    ->get()->sum('grand_total');

    }
    return $total;
}
function pendapatanMonthIn()
{
    $role = auth()->user()->role;
    $total = 0;
    if ($role==11) {
      $total =  Sale::where('date','LIKE','%'.date('Y-m').'%')->get()->sum('grand_total');
    }else{
        $store_id = auth()->user()->store_id;
        $total =  Sale::where('date','LIKE','%'.date('Y-m').'%')
                    ->where('store_id',$store_id)
                    ->get()->sum('grand_total');

    }
    return $total;
}

function memberTotal()
{
    $users = 0;
    if (auth()->user()->IN_STORE()) {
        $member_id = Sale::select('member_id')
                    ->where('store_id',auth()->user()->store_id)
                    ->get()
                    ->toArray();
                    
        $users = User::where('role',15)
                    ->whereIn('id',$member_id)
                    ->get()
                    ->count();

    }else{
         $users = User::orderBy('id','desc')
                    ->where('role',15)
                    ->get()
                    ->count();
    }
    return $users;
}

function productSold()
{
    $role = auth()->user()->role;
    $total = 0;
    if ($role==11) {
      $total =  SalesDetail::where('date',date('Y-m-d'))->get()->sum('total_item');
    }else{
        $store_id = auth()->user()->store_id;
        $total =  SalesDetail::where('date',date('Y-m-d'))
                    ->where('store_id',$store_id)
                    ->get()->sum('total_item');

    }
    return $total;
}
{
    # code...
}

function validationErrors($errors)
{
    $errorList = [];
    // dd($errors);
    foreach ($errors->all() as $attribute => $messages) {
        // dd($messages);
        $explode = explode(' ',$messages);
        $errorList[] = [
            'attribute' => $explode[1],
            'message'   => $messages,
        ];
    }
  

    return $errorList;
}

function generateOTP(){
    $otp = mt_rand(1000,9999);
    return $otp;
}
 
function statusOrder($status)
{
    if ($status==1) {
        return "Waiting Payment";
    }else if ($status==2) {
        return "Prepare Order";
    }else if ($status==3) {
        return "Delivery";
    }else if ($status==4) {
        return "Order Accepted";
    }else if ($status==5) {
        return "Canceled";
    }
    return "";
}

function nascondimiSendMessage($tujuan,$pesan)
{
    $apikey="b36b0460a07b324a3eb179ee30703006a39455da";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://starsender.online/api/sendText?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net'),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'apikey: '.$apikey
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_encode($response); 
}
 
function sendFirebaseGlobal($title,$body)
{
    $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
        ]
    ];
    $dataString = json_encode($data);

    $headers = ['Authorization: key=' . $SERVER_API_KEY,'Content-Type: application/json'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
           
    $response = curl_exec($ch);

    return $response;
}

function sendFirebasePerUser($idUser,$title,$body)
{
    $firebaseToken = User::where('id',$idUser)
                    ->whereNotNull('fcm_token')
                    ->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
        ]
    ];
    $dataString = json_encode($data);

    $headers = ['Authorization: key=' . $SERVER_API_KEY,'Content-Type: application/json'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
           
    $response = curl_exec($ch);

    return $response;
}

function sendFirebaseToAdminStore($store_id,$title,$body)
{
    $firebaseToken = User::where('store_id',$store_id)
                            ->whereIn('role',[12,13,14])
                            ->whereNotNull('fcm_token')
                            ->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
        ]
    ];
    $dataString = json_encode($data);

    $headers = ['Authorization: key=' . $SERVER_API_KEY,'Content-Type: application/json'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
           
    $response = curl_exec($ch);

    return $response;
}


function integerToRoman($integer)
	{
		$integer = intval($integer);
		$result = '';
		
		// Create a lookup array that contains all of the Roman numerals.
		$lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
 
		foreach ($lookup as $roman => $value) {
			$matches = intval($integer/$value);
			$result .= str_repeat($roman, $matches);
			$integer = $integer % $value;
		}

		return $result;
	}
