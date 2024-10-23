<?php
session_start();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            $email = $_POST['email'];
            $password = $_POST['password']; 
            $authController = new AuthController(); 
            $authController->access($email, $password);
            break;
    }
}

class AuthController {
    public function access($email, $password) { 
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login?=123456809',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $email, 'password' => $password),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);

        if (isset($response->data) && is_object($response)) { 
            $_SESSION['user_data'] = $response->data; 
            header("Location: ../Home.html");
            exit();
        } else {
            header("Location: ../index.html");
            exit(); 
        }
    }
}
?>
