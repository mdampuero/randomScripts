<?php
 header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
$errors = [];
if (!isset($_REQUEST["eventId"]))
    $errors[] = 'The param "eventId" is required';
if (!isset($_REQUEST["rut"]))
    $errors[] = 'The param "rut" is required';
if (count($errors)) {
    http_response_code(400);
    echo json_encode(['errors' => $errors]);
    exit;
}
$token = Helper::ObtenToken();
if ($token == "") {
    http_response_code(403);
    echo json_encode(['errors' => ['Error token']]);
    exit;
}

// $user = Helper::getOneRegistration('28199599',$token);
$registro = Helper::getAllRegistration($_REQUEST["eventId"], $token);
$result=[];
if($registro){
    if(key_exists('items',$registro)){
        foreach($registro["items"] as $item){
            $result[$item["c_3015786"]]=$item["email"];
        }
    }
}
if(key_exists($_REQUEST["rut"],$result)){
    http_response_code(400);
    echo json_encode(['message'=>'Este Rut ya ha sido ingresado con el correo '.$result[$_REQUEST["rut"]].', lo sentimos pero no es posible registrarse nuevamente.']);
}else{
    http_response_code(200);
    echo json_encode(['message'=>'OK']);
}
exit();

class Helper
{

    static function obtenToken()
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.swoogo.com/api/v1/oauth2/token.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic cl9qLWliTWpuNkNWZTlWTWJnbXRKOkxQdHhKTk1IUi1lcV9KLUFIWkQ5M01pRUs3N21rRHFDRUxyVlBMaFRteg=='
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        /*
        {
        type: "bearer",
        access_token: "ddIhaHvE8bN1-6dDscafAKzfq7OFEhC0ZQt_lu44XwsKNmrVHa4CYvRa0Q6l",
        expires_at: "2023-04-20 04:51:22"
        }
        */
        $result = json_decode($response, TRUE);
        if (isset($result["access_token"]))
            return $result["access_token"];
        return "";
    }

    static function obtenRegistrant($id, $token)
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.swoogo.com/api/v1/registrants/' . $id . '.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        //echo $response;
        //echo "-----<br>";
        $result = json_decode($response, TRUE);
        return $result;
    }
    static function getAllRegistration($eventId, $token)
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.swoogo.com/api/v1/registrants.json?event_id=' . $eventId . '&fields=c_3015786,email',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        //echo $response;
        //echo "-----<br>";
        $result = json_decode($response, TRUE);
        return $result;
    }

    static function getOneRegistration($id, $token)
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.swoogo.com/api/v1/registrants/' . $id . '.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        //echo $response;
        //echo "-----<br>";
        $result = json_decode($response, TRUE);
        return $result;
    }

}

//echo Helper::validaRut('1-9') ? 'Es válido' : 'No es válido
?>