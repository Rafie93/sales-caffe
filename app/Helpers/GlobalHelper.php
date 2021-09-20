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

function nascondimiSendMessage($phone,$message)
{
    $key = "57d46b36b90718a5b260ba54e0ad2b548d11e1cafe3bc373";
    $data = array(
        'key'       => $key,
        'phone_no'  => $phone,
        'message'   => $message
    );
    $data_string = json_encode($data);
    $ch = curl_init('http://116.203.92.59/api/send_message');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    curl_close($ch);
    return json_encode($result); 
}