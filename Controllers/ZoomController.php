<?php

class ZoomController extends Controller {
    function __construct() {
        parent::__construct();
    }

    function getToken($course_hash = ''){
        try {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => REDIRECT_URI."".$course_hash
                ],
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            $this->loadModel("zoomModel");
            $this->zoomModel->update_access_token(json_encode($token));
            header("Location:".URL."CourseController/managerCourse/".$course_hash);
            exit();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function ajax_create_meeting() {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $date = $_POST["date"];
        $title = $_POST["title"];
        $time = $_POST["time"];
        $pass = $_POST["pass"];

        $this->loadModel("zoomModel");
        $arr_token = $this->zoomModel->get_access_token();
        $accessToken = $arr_token->access_token;

        try {
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $title,
                    "type" => 2,
                    "start_time" => $date,
                    "duration" => $time, //
                    "password" => $pass
                ],
            ]);

            $data = json_decode($response->getBody());

            $result = array(
                "status" => "true",
                "url" => $data->join_url,
                "pass"=> $data->password,
            );
            echo json_encode($result);

        } catch(Exception $e) {
            if( 401 == $e->getCode() ) {
                $refresh_token = $this->zoomModel->get_refersh_token();

                $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
                $response = $client->request('POST', '/oauth/token', [
                    "headers" => [
                        "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                    ],
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $refresh_token
                    ],
                ]);
                $this->zoomModel->update_access_token($response->getBody());
                $this->ajax_create_meeting();
            } else {
                echo $e->getMessage();
            }
        }
    }

    function ajax_deleteMeet(){
        $meet_id = $_POST['meet_id'];
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $this->loadModel("zoomModel");
        $arr_token = $this->zoomModel->get_access_token();
        $accessToken = $arr_token->access_token;

        $response = $client->request('DELETE', '/v2/meetings/'.$meet_id, [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ]
        ]);

        if (204 == $response->getStatusCode()) {
            $result = array(
                "status" => "true",
                "message"=> "The Meeting was deleted.",
            );
        } else{
            $result = array(
                "status" => "false",
                "message"=> "The meeting could not be deleted because a zoom error.",
            );
        }
        echo json_encode($result);
    }

    function ajax_table_meetings(){
        $data['view'] = "zoom/meeting_tables";
        $data['reuniones'] = $this->ajax_list_meetings();

        $this->view->render($data);
    }

    function ajax_update_meeting(){
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $this->loadModel("zoomModel");
        $arr_token = $this->zoomModel->get_access_token();
        $accessToken = $arr_token->access_token;

        $date = $_POST["date"];
        $title = $_POST["title"];
        $time = $_POST["time"];
        $meet_id= $_POST["meet_id"];
        $password = $_POST['password'];
        if($_POST['newPass']){
            $response = $client->request('PATCH', '/v2/meetings/'.$meet_id, [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $title,
                    "type" => 2,
                    "start_time" => $date,
                    "duration" => $time,
                    "password" => $password
                ],
            ]);
        } else {
            $response = $client->request('PATCH', '/v2/meetings/'.$meet_id, [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $title,
                    "type" => 2,
                    "start_time" => $date,
                    "duration" => $time,
                ],
            ]);
        }

        if (204 == $response->getStatusCode()) {
            $result = array(
                "status" => "true",
                "message"=> "The Meeting was Updated.",
            );
        } else{
            $result = array(
                "status" => "false",
                "message"=> "The meeting could not be updated because a zoom error.",
            );
        }
        echo json_encode($result);
    }



}
?>