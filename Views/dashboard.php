        <?php
?>
        
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Courses</h1>
                <?php 
                    if($_SESSION['user']->getUser_type_id() == 2 || $_SESSION['user']->getUser_type_id() == 3 ){
                        echo " <a href='#' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i> Generate Report</a>";
                    }
                ?>
            </div>
            
            <!-- Content Row -->
            <div class="row col-md-12 m-auto d-flex">
                <!-- Earnings (Monthly) Card Example -->
            <?php 
                if(!empty($courses) || $courses != null) {
                foreach($courses AS $course){
                ?>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <div class="<?php echo ($course->getOpen() == 0) ? "opacity" : ""; ?> card bg-light bg-gradient border-left-primary shadow h-100 py-2 course">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                            <?php echo $course->getName();?></div>
                                            <div class=" p-1 text-justify mb-0 text-gray-800"><?php echo $course->getDescription();?></div>
                                        </div>
                                        <div class="col-auto m-auto">
                                        <?php
                                        echo "<img  width='90' src='".URL.$course->getImg()."'>";
                                        ?>                                         
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 m-auto text-center">
                                    <?php 
                                    if($course->getOpen() == 1){?>
                                        <a href='<?php echo URL."CourseController/courseDashboard/".$course->getHash();?>'class="btn btn-primary"> Access </a>
                                        <?php
                                            if($course->getUser_create()->getUser_id() === $_SESSION['user']->getUser_id() || $isAdmin){
                                                echo " <a href='".URL."CourseController/managerCourse/".$course->getHash()."' class='btn btn-info'> Administration </a>";
                                            }
                                        } else {
                                            if($course->getUser_create()->getUser_id() === $_SESSION['user']->getUser_id() || $isAdmin){
                                                echo "<a href='".URL.'CourseController/courseDashboard/'.$course->getHash()."'class='btn btn-primary'> Access </a>";
                                                echo " <a href='".URL."CourseController/managerCourse/".$course->getHash()."' class='btn btn-info'> Administration </a>";
                                            } else {
                                                echo " <h4 class='rounded bg-info p-2'> <i class='text-dark'>The course will open soon </i></h4>";
                                            }
                                        }
                                        ?>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                
            } else{
                echo "<h2 class='p-5 text-center'>No courses subscribed</h2>";
            }

            ?>

            <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->
</div>
