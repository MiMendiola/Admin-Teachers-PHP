<?php
?>
<div id="a" data-site="<?php echo URL;?>" class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $course->getName()?> Administration</h1>
    </div>
    <div class="row">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Course Info</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="" class="table  table-hover">
                        <thead>
                            <tr>
                                <th>Course ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>User create</th>
                                <th>Folder</th>
                                <th>Img</th>
                                <th>date_create</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    $creator = $course->getUser_create();

                                    echo "<td id='td-course_id' data-val='".$course->getCourse_id()."'>".$course->getCourse_id()."</td>";
                                    echo "<td id='td-course-name'>".$course->getName()."</td>";
                                    echo "<td>".$course->getDescription()."</td>";
                                    echo "<td>".$creator->fullName()."</td>";
                                    echo "<td>".$course->getFolder()."</td>";
                                    echo "<td> <img width='40' src='".URL.$course->getImg()."'/></td>";
                                    echo "<td>".$course->getDate_create()."</td>";
                                    if($course->getOpen() == 0){
                                        echo "<td> <span class='text-light bg-dark pl-2 pr-2  rounded'> Closed </span></td>";
                                    } else {
                                        echo "<td> <span class='text-light bg-success pl-2 pr-2  rounded'> Open </span></td>";
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <caption class="m-auto text-center">
                    <button data-bs-toggle='modal' data-bs-target="#editCourse" class='btn mt-3 btn-primary'>Edit Course</button>
                    <button id='btn-o' class='<?php echo ($course->getOpen() != 0) ? "d-none"  : "";?> btn btn-success mt-3'>Open</button><button id='btn-c' class='<?php echo ($course->getOpen() == 0) ? "d-none"  : ""?> btn btn-danger mt-3'>Closed</button>
                </caption>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $course->getName()?> Test</h6>
            <a href='<?php echo URL ."TestController/createTest" ?>' class='btn mt-3 btn-primary rounded-circle btn-sm float-right' title="New Test"><span class="fa fa-plus"></span></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="" class="table table-hover">
                    <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Description</th>
                        <th>Total Questions</th>
                        <th>Questions this Test</th>
                        <th>Time for Doing</th>
                        <th>Date Open</th>
                        <th>Date Closed</th>
                        <th>True Count</th>
                        <th>Wrong Discount</th>
                        <th>Random</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $control = false;
                        $statu = "";
                            if(!empty($course->getTests())){
                                $statu = "false";
                                foreach($course->getTests() AS $test){
                                    $count = 0;

                                    if($test->getQuestions() != NULL){
                                        $count =count($test->getQuestions());
                                    }
                                    if($count == $test->getTotalQuestions()){
                                        $statu = true;
                                    } else {
                                        $status = false;
                                    }
                                    if($count != $test->getTotalQuestions()){
                                        echo "<tr class='text-black' style='background-color: #e74a3b3d;'>";
                                    } else {
                                        $control = true;
                                        echo "<tr>";
                                    }
                                    echo "<td>".$test->getName()."</td>";
                                    echo "<td class='text-justify'>".$test->getDescription()."</td>";
                                    echo "<td>".$test->getTotalQuestions()."</td>";
                                    echo "<td>".$count."</td>";
                                    echo "<td>".$test->getTime()." mins</td>";
                                    echo "<td>".$test->getDate()."</td>";
                                    echo "<td>".$test->getDateClose()."</td>";
                                    echo "<td>".$test->getTrueCount()."</td>";
                                    echo "<td>".$test->getWrongDiscount()."</td>";
                                    echo ($test->getRandom() == 1)?"<td>True</td>" : "<td>False</td>";
                                    echo  ($test->getOpen() == 0) ? "<td> <span class='rounded pl-2 pr-2 bg-gradient-dark text-white'>Closed</span></td>" : "<td><span class='rounded pl-2 pr-2 bg-gradient-success text-white'>Open</span></td>";
                                    echo "<td>";
                                    echo "<a href='".URL."TestController/editTest/".$course->getHash()."/".$test->getHash()."' class='btn btn-primary'>Insert Questions</a>";
                                    if($control){
                                        if($test->getOpen() == 0){
                                            echo "<button class='btn btn-success btn-open-test' data-test-status='true' data-test-id='".$test->getId()."'>Open Test</button>";
                                        } else {
                                            echo "<button class='btn btn-warning btn-open-test' data-test-status='false' data-test-id='".$test->getId()."'>Close Test</button>";
                                        }
                                    } else {
                                        echo "<button class='btn btn-dark' disabled>Open Test</button>";
                                    }
                                    echo "<button class='btn btn-danger btn-test-delete' data-test-id='".$test->getId()."'>Delete</button>";
                                    if($control){
                                        echo "<a href='".URL."TestController/viewTestStatus/".$test->getHash()."/".$course->getHash()."' class='btn btn-info btn-v-s' >View Status</a>";
                                    } else {
                                        echo "<button class='btn btn-dark' disabled>View Status</button>";
                                    }
                                    echo "</tr>";

                                }
                            }

                        ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=" card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Teacher Info</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Passport</th>
                            <th>Email</th>
                            <th>Normal IP</th>
                            <th>User Login</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        echo "<tr>";
                        echo "<td>".$creator->fullName()."</td>";
                        echo "<td>".$creator->getPassport()."</td><td>".$creator->getEmail()."</td><td>".$creator->getNormal_ip()."</td>";
                        echo ($creator->getFirstTime() == "0000-00-00") ? "<td>Not Loggin yet </td>" : "<td>". $creator->getFirstTime() ."</td>";
                        echo "</tr>";
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="count-questions" data-value="<?php echo $statu; ?>">
        <div class=" card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Students Info</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table id="usr-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Passport</th>
                            <th>Email</th>
                            <th>Normal IP</th>
                            <th>User Login</th> 
                            <th>Acctions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if(!is_null($course->getStudents())){
                        foreach($course->getStudents() AS $user){
                            //save the Users Id
                            $usersId[] = $user->getUser_id();
                            echo "<tr>";

                            echo "<td id='td-fullName'>".$user->fullName()."</td>";
                            echo "<td>".$user->getPassport()."</td><td>".$user->getEmail()."</td><td>".$user->getNormal_ip()."</td>";
                            echo ($user->getFirstTime() == "0000-00-00") ? "<td>Not Loggin yet </td>" : "<td>". $user->getFirstTime() ."</td>";

                            echo "<td><button class='btn btn-danger btn-un btn-sm' title='Unsuscribe Student' data-course-id='".$course->getCourse_id()."' data-user-id='".$user->getUser_id()."'> <span class='fas fa-trash-alt'></span>
                            </button></td>";

                            echo "</tr>";
                        }
                    }
                         ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-md-12 mt-5 mb-2">
                <a id="lz" href="<?php echo "https://zoom.us/oauth/authorize?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI.$course->getHash()?>" class="btn btn-primary">
                    <span class="fas fa-video" aria-hidden="true"> </span> Login Zoom
                </a>
                <button id="cm" class="btn btn-success" data-toggle="modal" data-target="#createMeet">
                    <span  class="fas fa-video" aria-hidden="true"> </span> Create Meeting
                </button>
                <span class="bg-danger text-light rounded ml-1"><?php echo $loginZoom?></span>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Meetings Info</h6>
            </div>
            <div class="card-body">
                <div id="meetingsHere" class="table-responsive">
                <?php if($loginZoom == "" && isset($reuniones)){
                ?>
                    <table id="usr-table" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Meeting Title</th>
                            <th>Start Time</th>
                            <th>Duration</th>
                            <th>Create At</th>
                            <th>URL Join</th>
                            <th>Acctions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!is_null($reuniones)){

                            foreach($reuniones AS $reunion){
                                //save the Users Id
                                echo "<tr>";

                                echo "<td>".$reunion->topic."</td>";
                                echo "<td>".$reunion->start_time."</td><td>".$reunion->duration."mins</td><td>".date("Y-m-d H:i:s",strtotime($reunion->created_at))."</td>";
                                echo "<td> <a href='".$reunion->join_url."' target='_blank'>".$reunion->join_url."</a></td>";

                                echo "<td><button class='btn btn-danger btn-dmeet' title='Delete Meeting' data-meet-id='".$reunion->id."'> <span class='fas fa-trash-alt'></span>
                            </button>
                            <button class='btn btn-warning btn-umeet' title='Update Meeting' data-topic='".$reunion->topic."'  data-duration='".$reunion->duration."' data-date='".$reunion->start_time."'  data-meet-id='".$reunion->id."'> <span class='fas fa-pen'></span>
                            </button>
                            </td>";

                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "<h4 class='text-center'>You haven't meetings.</h4>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-10 m-auto">
            <div class="row">
                <div class="col-md-12 mt-5 mb-2">
                    <button data-bs-toggle='modal' data-bs-target="#inserFile" class="btn btn-primary">
                        <span class="fa fa-plus-circle" aria-hidden="true"> </span> New File
                    </button>
                </div>
            </div>
            <div class="table-responsive">
            <h1 class="h4  text-center mb-0 text-gray-800">File Manager</h1>
                <table id="files-table" class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Extension File</th>
                            <th>Download</th>
                            <th>View</th>
                            <th>Deletes</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                            <?php
                            foreach($files AS $file){
                                    $ext = explode(".", $file);
                                echo "<tr>";
                                echo "<td>$file</td>";
                                echo "<td>$ext[1]</td>";
                            ?>
                            <td>
                               
                                <a title="Download file"  href="<?php echo URL. $course->getFolder() .'/'.$file?>" download="<?php echo $file ?>" class="btn btn-success btn-sm dw">
                                    <span class="fa fa-download"></span>
                                </a>      
                            </td>
                            <td>
                                <?php 
                                if(in_array($ext[1], $extValid)){
                                ?>
                                <span  title="View File" class="btn btn-warning btn-sm sh" data-file="<?php echo $file ?>" data-url-file="<?php echo $course->getFolder() .'/'.$file?>" data-bs-toggle='modal' data-bs-target="#showFile">
                                    <span class="fa fa-eye"></span>
                                </span>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <span title="Delete File" data-file="<?php echo $file ?>" data-url-file="<?php echo $course->getFolder() .'/'.$file?>" class="btn btn-danger btn-sm dr">
                                    <span class='fas fa-trash-alt'></span>
                                </span>
                            </td>
                        </tr>
                            <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<!-- NEW FILE MODAL -->
<div  id="inserFile" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New File</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form" data-url-file="<?php echo $course->getFolder()?>" enctype="multipart/form-data"  id="file-form" action="" method="POST" >
                <div class="input-group mb-4">
                    <span class="input-group-text bg-primary"><i
                            class="fa  fa-file text-white"></i></span>
                    <input class="form-control col-md-12" placeholder="New File" type="file" value="NULL" id="newFile" required>
                </div>

                <div class="input-group">
                    <input class="btn m-auto btn-success" placeholder="New File" type="submit" value="Upload File" id="upload">
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- SHOW FILE  -->
<div class="modal fade" id="showFile" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="showf"></div>
      </div>
      <div class="modal-footer">
         <button type="button" id="cancel" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- UPDATE COURSE MODAL WINDOWS -->
<div class="modal fade" id="editCourse" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Course <?php echo $course->getName() ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="course-update-form" method="POST" role="form" enctype="multipart/form-data">
            <div class="controls">
                <div class="row">
                    <div class="col-md-10 m-auto">
                        <div class="form-group">
                            <label for="course_img">Course Photo</label>
                            <input id="course_img" type="file" name="course_img" class="form-control" placeholder="Course IMG" >
                        </div>
                    </div>
            </div>
                <div class="row">
                    <div class="col-md-10 m-auto">
                        <div class="form-group">
                            <label for="course_name">Course Name *</label>
                            <input id="course_name" value='<?php echo $course->getName() ?>' type="text" name="course_name" class="form-control" placeholder="Course Name" required="required" data-error="Firstname is required.">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10  m-auto ">
                        <div class="form-group border">
                            <label for="students">Select Students</label>
                            <select class="selectpicker form-control" id="students" multiple aria-label="Student select">
                                <?php

                                foreach($users as $user){
                                    if(!isset($usersId)){
                                        echo "<option value='".$user->getUser_id()."'>".$user->fullName()."</option>";
                                    } else if(!in_array($user->getUser_id(), $usersId)){
                                        echo "<option value='".$user->getUser_id()."'>".$user->fullName()."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 m-auto">
                        <div class="form-group">
                            <label for="course_description">Course Description *</label>
                            <textarea id="course_description" name="course_description" class="form-control" rows="4" required="required" data-error="Please, leave us a message."><?php echo $course->getDescription()?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 m-auto text-center">
                        <input type="submit" class="btn btn-success btn-send  pt-2 btn-block" value="Update Course" >
                    </div>
                </div>
            </div>
        </form>
    </div>
      <div class="modal-footer">
         <button type="button" id="cancel" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--MODAL WINDOWS FOR CREATE A NEW MEETING-->
<div class="modal fade" id="createMeet" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Create a New Meeting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                <form action="" method="post" id="newMeeting">
                    <div class="modal-body">
                        <div class="container-fluid">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="meetTitle" class="form-label">Meeting Title</label>
                                        <input type="text" value="<?php echo $course->getName(). " Lesson: ".date("Y-m-d")?>" class="form-control" id="meetTitle" name="meetTitle" placeholder="Meeting Title..." require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dateM" class="form-label" >Date</label>
                                        <input type="datetime-local" value="<?php echo date("Y-m-d\TH:i:s") ?>" class="form-control" id="dateM" name="dateM" required/>
                                    </div>
                                    <div class="mb-3" id="update">
                                    </div>
                                    <div class="mb-3">
                                        <label for="meetTime" class="form-label">Meeting Time</label>
                                        <input type="number" class="form-control" id="meetTime" name="meetTime"  min="5" value="55" max="55" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meetP" class="form-label">Meeting Password</label>
                                        <input type="text" class="form-control" id="meetP" value="<?php echo $random?>" name="meetP" disabled>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="btn-meet-c" class="btn btn-success" data-bs-dismiss="modal">Generate</button>
                    </div>
            </form>
        </div>
    </div>
</div>



<!--MODAL WINDOWS FOR UPDATE A NEW MEETING-->
<div class="modal fade" id="updateMeet-m" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="m-title-up"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="updateMeeting-f">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="upTopic" class="form-label">Meeting Title</label>
                                <input type="text" value="" class="form-control" id="upTopic" name="upTopic" placeholder="Meeting Title..." require>
                            </div>
                            <div class="mb-3">
                                <label for="dateMUp" class="form-label" >Date</label>
                                <input type="datetime-local" value="" class="form-control" id="dateMUp" name="dateMUp" required/>
                            </div>
                            <div class="mb-3" id="update">
                            </div>
                            <div class="mb-3">
                                <label for="meetTimeUp" class="form-label">Meeting Time</label>
                                <input type="number" class="form-control" id="meetTimeUp" name="meetTimeUp"  min="5" value="55" max="55" require>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox" name="nuevaPass" id="nuevaPass" title="If you don't check this input, you will continue to use the last password."/> <label for="nuevaPass">Do you want to change the password?</label>
                                <br>
                                <label for="passUp" class="form-label">New Password</label>
                                <input type="text" class="form-control" id="passUp" name="passUp" disabled/>
                            </div>

                                <input type="hidden" class="form-control" id="mup" value="" name="mup" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-meet-upd" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>