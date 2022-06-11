<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo URL;?>assets/img/icon.jpg" type="image/x-icon">

    <title>Virtual Community</title>
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

    <!-- FULLCALENDAR PLUGIN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
</head>
<body class="mt-5">

<div class="text-center">
    <h3 class="text-primary"><?php echo $title; ?></h3>
</div>
<div class="row col-md-12 m-auto">
    <form method="POST" action="<?php echo URL ?>AdminController/TeacherCreate">
        <div class="row">

            <div class="card shadow mb-4 col-md-10 m-auto "  style="margin-bottom: 0 !important;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Teacher Info</h6>
                </div>
                <div class="card-body p-2 py-5">
                        <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                            <input type="text" class="form-control" placeholder="Teacher Code..." id="code" name="code" value="" required/>
                        </div>

                        <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                            <input type="text" class="form-control" placeholder="DNI...(123456789L)" id="passport" name="passport" value="" required/>
                        </div>
                    <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                        <input type="text" class="form-control" placeholder="Your Name" id="name" name="name" value="" required/>
                    </div>
                    <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                        <input type="text" class="form-control" placeholder="Your Last Name" id="last_name" name="last_name" value="" required/>
                    </div>

                    <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                        <input type="email" class="form-control" placeholder="Your email" id="email" name="email" value="" required/>
                    </div>

                    <div class="input-group align-items-start">
                        <div class="col-md-6 d-flex align-items-center mb-2">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-key-fill text-white"></i></span>
                            <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" required/>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-key-fill text-white"></i></span>
                            <input type="password" class="form-control" id="c_pass" placeholder="Confirm Password" required/>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="col-md-7"></div>
                        <span id="pp-diferent" class='text-danger col-md-5 d-none'>The both passworts are different.</span>
                        <span id="pp-true" class='text-success col-md-5 d-none'>The password is Ok.</span>
                    </div>

                </div>
            </div>
        </div>
        <input type="hidden" class="form-control" placeholder="Teacher Code..." id="url" name="code" value="<?php echo URL?>" required/>

        <input id="valido" type="hidden" name="valid" value="<?php echo URL; ?>"/>
        <div class="row mt-4">
            <div class="d-grid col-2 mx-auto mb-4">
                <button class="btn btn-primary" id="btn-newTeacher" name="create">Create Teacher</button>
            </div>
        </div>
</div>
</form>
</div>

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

</body>
</html>
