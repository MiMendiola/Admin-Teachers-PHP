    <!-- Page Wrapper -->
<div id="wrapper">
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URL ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php URL?>/assets/img/icon.jpg" alt="Logo Empresa" title="Logo Empresa" width="50" height="50"/>
        </div>
        <div class="sidebar-brand-text mx-3">ULM Admin </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo URL;?>main/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Courses and Students
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa  fa-graduation-cap"></i>
            <span>Courses</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Options:</h6>
                <?php
                if($_SESSION['user']->getUser_type_id() == 2){
                    echo "<a class='collapse-item' href='". URL ."adminController/coursesManager'>Create new Course</a>";
                } elseif($_SESSION['user']->getUser_type_id() ==3) {
                    echo "<a class='collapse-item' href='".URL."adminController/coursesManager/".$_SESSION['user']->getHash()."'>Create new Course</a>";
                }
                ?>
                <a class="collapse-item" href="<?php echo URL;?>TestController/createTest">Create Test</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo URL;?>main/newUsers" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa  fa-users"></i>
            <span>Students</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Options Students:</h6>
                <a class="collapse-item" href="<?php echo URL;?>adminController/createStudent">New Student</a>
                <?php
                if($_SESSION['user']->getUser_type_id() === 2){
                ?>
                    <a class="collapse-item" href="#" id='createTeacherWithCode'>Teacher create themselves</a>
                <?php
                }
                ?>
                <a class="collapse-item" href="<?php echo URL;?>adminController/showUsers">View Students</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
    <!-- MODAL FOR GET THE  TEACHER CODE -->
    <div class="modal" id="teacherCodeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teacher Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">Share this code with the teacher so they can create their account. This code will only be valid for 30 minutes:</p>
                    <h2 class="text-center" id="showTeacherCode"></h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
