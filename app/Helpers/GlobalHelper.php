<?php

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
    // $key = "57d46b36b90718a5b260ba54e0ad2b548d11e1cafe3bc373";
    // $data = array(
    //     'key'       => $key,
    //     'phone_no'  => $tujuan,
    //     'message'   => $pesan
    // );
    // $data_string = json_encode($data);
    // $ch = curl_init('http://116.203.92.59/api/send_message');
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_VERBOSE, 0);
    // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //     'Content-Type: application/json',
    //     'Content-Length: ' . strlen($data_string))
    // );
    // $result = curl_exec($ch);
    // curl_close($ch);
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
