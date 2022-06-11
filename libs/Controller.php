<?php

/**
 * This class is the base Controller class
 */
Class Controller {
    
    function __construct() {
        $this->view = new View();
    }

    function isLogin(){
        if(!isset($_SESSION["token"]) || !isset($_COOKIES["token"]) ){
            header("Location:".URL."/main/login");
            exit();

        } elseif(($_SESSION["token"] != $_COOKIE["token"])){
            $this->error(401);
            exit();
        }
    }

    function isAdTe(){
        if($_SESSION['user']->getUser_type_id() == 2 || $_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            $this->error(401);
            die();
        }
    }

    function infoAdTe(){
        if($_SESSION['user']->getUser_type_id() == 2 || $_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            return false;
        }
    }

    function infoTeacher(){
        if($_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            return false;
        }
    }

    function infoAdmin(){
        if($_SESSION['user']->getUser_type_id() == 2){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin(){
        if($_SESSION['user']->getUser_type_id() == 2){
            return true;
        } else {
            $this->error(401);
        }

        return false;
    }
    
    function isTeacher(){
        if($_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            $this->error(401);
        }

        return false;
    }

    function loadModel($model){
        $url = './Models/'.$model.'.php';
        //Check if the model name exist in the proyect
        if(file_exists($url)){
            require $url;
            return $this->$model = new $model();
        } else {
            die("Error, model not found: ".$url);
        }
    }

    function error($errorType = 400){
        switch($errorType){
            case 400:
                $this->view->render("/errors/400");
                break;
            case 401: 
                $this->view->render("/errors/401");
                break;
            case 404:
                $this->view->render("/errors/404");
                break;
        }
    }

    function ajax_list_meetings($next_page_token = '') {
        $this->loadModel("zoomModel");
        $arr_token = $this->zoomModel->get_access_token();
        $accessToken = $arr_token->access_token;
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $arr_request = [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ]
        ];

        if (!empty($next_page_token)) {
            $arr_request['query'] = ["next_page_token" => $next_page_token];
        }
        $response = $client->request('GET', '/v2/users/joseluis-cg@hotmail.com/meetings', $arr_request);
        $data = json_decode($response->getBody());
        $result = array();
        if (!empty($data)) {
            foreach ( $data->meetings as $d ) {
                array_push($result,$d);
            }
            if ( !empty($data->next_page_token) ) {
                $this->ajax_list_meetings($data->next_page_token);
            }
            return $result;
        } else {
            return null;
        }
    }

    function getToken(){
        try {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => REDIRECT_URI
                ],
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            $this->loadModel("zoomModel");
            $this->zoomModel->update_access_token(json_encode($token));
            echo "Access token inserted successfully.";
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function getIP(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

?>