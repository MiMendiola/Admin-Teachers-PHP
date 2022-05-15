<!-- Sidebar -->
<!-- Page Wrapper -->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
<div id="wrapper">
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URL;?>main/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Virtual Community  <sup>1</sup></div>
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