<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo URL;?>assets/img/icon.jpg" type="image/x-icon">

    <title>Virtual Community - Test <?php echo $test->getName();?></title>
    <!-- BOOTSTRAP STYLES -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="<?php echo URL;?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">

    <!-- DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.5/datatables.min.css"/>

    <!-- OUR STYLES -->
    <link href="<?php echo URL;?>assets/css/styles.css" rel="stylesheet">
    <link href="<?php echo URL;?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL;?>assets/vendor/toastr/toastr.css">
    <link href="<?php echo URL."assets/vendor/tempo/inc/"?>TimeCircles.css" rel="stylesheet">


    <!-- FULLCALENDAR PLUGIN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
</head>
<body id="page-top">
<!--NAVBAR-->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>



            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1" title="Calendar">
                    <a class="nav-link dropdown-toggle" id="calen" href="#"  role="button"
                       data-bs-toggle="modal" data-bs-target="#view-calendar">
                        <i class="fa fa-calendar"></i>
                        <!-- Counter - Calendar -->
                        <span id="" class="badge badge-danger badge-counter"></span>
                    </a>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none" title="Messages center">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                         aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                       placeholder="Search for..." aria-label="Search"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <!-- Counter - Messages -->
                        <span id="msgNew" class="badge badge-danger badge-counter"></span>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="messagesDropdown">
                        <h6 class="dropdown-header">
                            Message Center
                        </h6>

                        <form method="POST" id="view-mail"  action=""class="here">
                            <h5 class=" text-center p-4 text-gray-500">You don't have messages.</h5>
                        </form>


                        <a class="dropdown-item text-center small text-gray-500" data-bs-toggle="modal" data-bs-target="#write-msg" href="#">Write Messages</a>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <?php
                    if($_SESSION['user']->getPhoto() == NULL){
                        ?>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">  <?php echo $_SESSION['user']->getName() ." ". $_SESSION['user']->getLast_name();?></span>

                            <img class="img-profile rounded-circle"
                                 src="<?php echo URL?>assets/img/default.png">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">  <?php echo $_SESSION['user']->getName() ." ". $_SESSION['user']->getLast_name();?></span>

                            <img class="img-profile rounded-circle" title='<?php echo $_SESSION['user']->getName() ." ". $_SESSION['user']->getLast_name();?>' alt='<?php echo $_SESSION['user']->getName() ." ". $_SESSION['user']->getLast_name();?>'  src="<?php echo URL.$_SESSION['user']->getPhoto()?>">
                        </a>

                        <?php
                    }
                    ?>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo URL; ?>main/updateStudent">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Edit Profile
                        </a>

                        <?php

                        //Insert return option to admin using Student viewer
                        if(isset($_SESSION['user_view'])) {
                            ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo URL; ?>adminController/comeBack">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Return at your Profile
                            </a>
                            <?php
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo URL;?>main/logout">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
        <div class="container-fluid">


            <!-- MODAL FOR WRITE A MESSAGE -->
            <div id="write-msg" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="msg-form" method="POST" role="form">
                                <div class="controls">
                                    <input id="valid" type="hidden" name="valid" value="<?php echo URL; ?>"/>
                                    <div class="row">
                                        <div class="col-md-12 m-auto">
                                            <div class="form-group">
                                                <label for="subject">Subject:</label>
                                                <input id="subject" type="text" name="subject" class="form-control" required placeholder="Subject..." >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 m-auto ">
                                            <div class="form-group border">
                                                <label for="students">Receptor:</label>
                                                <select class="selectpicker form-control" id="receptor" required multiple aria-label="Student select">
                                                    <?php
                                                    foreach($users as $user){
                                                        echo "<option value='".$user->getUser_id()."'>".$user->fullName()."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 m-auto">
                                            <div class="form-group">
                                                <label for="msg">Course Description *</label>
                                                <textarea id="msg" name="msg" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 m-auto text-center">
                                            <input type="submit" class="btn btn-success btn-send pt-2 btn-block" value="Send Message" >
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- MODAL FOR VIEW A MESSAGE -->
            <div id="view-msg" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">View Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="dropdown-list-image d-flex flex-justify align-items-center mr-3">
                                <img id="usr-img"  width='80' class="rounded-circle" src="" alt="...">
                                <div id="UserName" class="ml-3 p-3 text-gray-500 text-wrap"></div>
                            </div>
                            <div class="row">
                                <div id="signature" class="text text-bolder fw-bold m-3"></div>
                            </div>
                            <div>
                                <div id="msgText" class="text-justify"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn m-auto btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL FOR VIEW A CALENDAR -->
            <div id="view-calendar" class="modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Calendar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="calendar" style></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for create a new calendar event-->
            <div class="modal fade" id="editCalendar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-sm|lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" id="calendarEvent">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="eventName" class="form-label">Event Name</label>
                                    <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Name Event..." require>
                                </div>
                                <div class="mb-3">
                                    <label for="datec" class="form-label" >Date</label>
                                    <input type="datetime-local" data-end='' class="form-control" id="datec" name="datec">
                                </div>
                                <div class="mb-3" id="update">
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label" >Event Color</label>
                                    <input type="color" class="form-control" id="color" name="color">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="upd"class="btn btn-warning" data-bs-dismiss="modal">Update</button>
                                <button type="button" id="dlt" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                                <button type="button" id="crt" class="btn btn-info" data-bs-dismiss="modal">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--END NAVBAR-->
    </div>
</div>

</div>
<!-- /.container-fluid -->
<div id="val" data-site="<?php echo URL;?>" class="container-fluid mb-3">

    <div class="row">
        <div id="helperShow" class="col-md-4 m-auto">
            <div id="tempo" class="bg-light" style="border-radius: 15px;" data-timer= "<?php echo $test->getTime()*60?>"></div>
            <button class="btn btn-info" id="hideTem">Hide</button>
            <button class="btn btn-info" id="showTem">Show</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 m-auto">
            <div id="tempoo" data-timer= "<?php echo $test->getTime()*60?>"></div>
        </div>
    </div>

    <div class="row text-justify">
        <!-- Eliminar este col y dejar el contenido en el div anterior para la pantalla completa del formulario-->
        <form  id="sent-test-form" data-test-hash="<?php echo $test->getHash(); ?>" data-userHash="<?php echo $_SESSION['user']->getHash(); ?>" action="<?php echo URL."TestController/processTest/".$test->getHash() ?>" method="POST">

        <div class="card p-4 col-md-10 m-auto">
                <div class="card-body">
                    <h4 class="mb-5 text-center"><?php echo $test->getName() ?></h4>
                    <?php
                    $count = 0;
                    //Guardamos las preguntas en una variable para desordenarlas en el caso de que sea random
                    $randomQuestions = $test->getQuestions();
                    if($test->getRandom() == 1){
                        shuffle($randomQuestions);
                    }
                    foreach($randomQuestions AS $question){
                        $count++;
                        ?>
                        <div class="row">
                            <div class="col-md-1 rounded ">
                                <h4 class="p-2"><?php echo $count ?></h4>
                            </div>
                            <div class="col-md-11 m-0 pl-1">
                                <ul class="list-group pb-5">
                                    <li class="list-group-item active" aria-current="true"><h5> <?php echo $question->getText() ?></h5></li>
                                    <?php
                                    switch ($question->getQuestionType()){
                                        case "multiple":
                                            $rom = $question->getAnswers();
                                            shuffle($rom);
                                            foreach ($rom as $answer) {
                                                echo "<li class='border-0 list-group-item pl-5'>";
                                                echo "&nbsp; <input class='form-check-input me-1' type='checkbox' name='".$answer->getQuestionId()."[]' value='".$answer->getId()."'>";

                                                echo "&nbsp; " . $answer->getText();
                                                echo "</li>";
                                            }
                                            break;
                                        case "simple":
                                            $rom = $question->getAnswers();
                                            shuffle($rom);
                                            foreach ($rom as $answer) {
                                                echo "<li class='border-0 list-group-item pl-5'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' name='".$answer->getQuestionId()."' value='".$answer->getId()."'>";

                                                echo "&nbsp; " . $answer->getText();
                                                echo "</li>";
                                            }
                                            break;
                                        case "written":
                                            echo  "<li class='border-0 pt-4 list-group-item '>";
                                            echo     "<input type='text'  name='".$question->getResult()[0]->getQuestionId()."' id='".$question->getResult()[0]->getQuestionId()."' class='form-control input-group-lg' placeholder='your answer...' data-type='0' aria-describedby='basic-addon1' />";
                                            echo  "</li>";
                                            break;
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>


                        <?php
                    }
                    ?>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success" id="btn-send-test"> Submit Form</button>
                </div>
            </div>
            <input type="hidden" name="test_hash" value="<?php echo $test->getHash() ?>">
        </form>

    </div>
</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Comunidad Virtual - Jose Luis Calleja Gar&iacute;a <?php echo date("Y") ;?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<!-- DELETE AFTER TEST -->
<script src="<?php echo URL;?>assets/js/jquery.js"></script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" ></script>

<!-- OUR SCRIPTS -->
<script src="<?php echo URL;?>assets/js/main.js"></script>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo URL;?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?php echo URL;?>assets/js/sb-admin-2.min.js"></script>

<!-- JS DATATABLES TOASTR ALERT AND FULLCALENDAR-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.5/datatables.min.js"></script>
<script src="<?php echo URL;?>assets/vendor/toastr/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<!-- OUR SCRIPTS -->
<script src="<?php echo URL;?>assets/js/test_scripts.js"></script>
<script type="text/javascript" src="<?php echo URL."assets/vendor/tempo/inc/"?>TimeCircles.js"></script>
</body>
</html>
