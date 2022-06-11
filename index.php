<?php
    header('Referrer-Policy', 'no-referrer-when-downgrade');
    header('X-Content-Type-Options', 'nosniff');
    header('X-XSS-Protection', '1; mode=block');
    header('X-Frame-Options', 'DENY');
    header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    header('Content-Security-Policy', "style-src 'self'");
    header("Access-Control-Allow-Origin: *");

    require_once "./libs/Core.php";
    require_once './assets/vendor/vendor/autoload.php';
    require_once './Classes/Zoom.php';
    require_once './Classes/Course.php';
    require_once './Classes/User.php';
    require_once './Classes/Forum.php';
    require_once './Classes/Test.php';
    require_once './Classes/Question.php';
    require_once './Classes/QuestionSimple.php';
    require_once './Classes/QuestionMultiple.php';
    require_once './Classes/QuestionWritten.php';
    require_once './Classes/Answer.php';
    require_once './libs/Database.php';
    require_once './libs/Controller.php';
    require_once './libs/Model.php';
    require_once './libs/View.php';
    require_once "./libs/App.php";
    require_once "./config/config.php";

    session_start();

    $App = new App();
?>