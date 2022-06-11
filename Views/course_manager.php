<div class="text-center">
    <h3 class="text-primary">New Course</h3>
</div>
<div class = "col-md-10 m-auto pb-5">
    <form id="course-form" method="POST" role="form" enctype="multipart/form-data">
        <div class="controls">
        <input id="valid" type="hidden" name="valid" value="<?php echo URL; ?>"/>
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
                        <input id="course_name" type="text" name="course_name" class="form-control" placeholder="Course Name" required="required" data-error="Firstname is required.">
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
                                echo "<option value='".$user->getUser_id()."'>".$user->fullName()."</option>";
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
                        <textarea id="course_description" name="course_description" class="form-control" placeholder="Write your description here." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 m-auto text-center">
                    <input type="submit" class="btn btn-success btn-send  pt-2 btn-block" value="Create Course" >
                </div>
            </div>
        </div>
    </form>
</div>
