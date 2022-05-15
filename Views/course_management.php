<?php
?>
<div id="valid" data-site="<?php echo URL;?>" class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $course->getName()?> Administration</h1>
    </div>
    <div class="row">
        <div class=" shadow mb-4">
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
                                        echo "<td> Closed </td>";
                                    } else {
                                        echo "<td> Open </td>";
                                    }
                                ?> 
                            </tr>
                        </tbody>
                    </table>
                </div>
                <caption class="m-auto text-center">
                    <button data-bs-toggle='modal' data-bs-target="#editCourse" class='btn btn-primary'>Edit Course</button>
                    <button id='btn-o' class='<?php echo ($course->getOpen() != 0) ? "d-none"  : "";?> btn btn-success'>Open</button><button id='btn-c' class='<?php echo ($course->getOpen() == 0) ? "d-none"  : ""?> btn btn-danger'>Closed</button>
                </caption>
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


    <div class="row">
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

                    if(is_null($course->getStudents())){
                        echo "<tr><td colspan='6'class='text-center'> This course don't have Students yet</td></tr>";
                    } else {

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
                                    if(!in_array($user->getUser_id(), $usersId)){
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