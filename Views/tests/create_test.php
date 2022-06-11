<?php 
//name	description	questions	score	time	did
?>
<div class="text-center">
    <h3 class="text-primary">New Test</h3>
</div>
<div class = "col-md-10 m-auto pb-5">
    <form id="course-form" action="<?php echo URL."TestController/saveTest"?>" method="POST" role="form" >
        <div class="controls">
        <input id="valid" type="hidden" name="valid" value="<?php echo URL; ?>"/>
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="form-group">
                        <label for="name">Test Name *</label>
                        <input id="name" type="text" name="name" class="form-control" placeholder="Test Name" required="required" data-error="name is required.">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 m-auto">
                    <div class="form-group">
                        <label for="date_open">Date Opened *</label>
                        <input id="date_open" type="datetime-local" value="<?php echo date('Y-m-d\TH:i:s'); ?>" name="date_open" class="form-control" placeholder="date for public your exam" required="required" data-error="question is required.">
                    </div>
                </div>
                <div class="col-md-4 m-auto">
                    <div class="form-group">
                        <label for="dateClosed">Date Closed *</label>
                        <input id="dateClosed" type="datetime-local" name="dateClosed" value="<?php echo date('Y-m-d\TH:i:s', strtotime("+1 hours")); ?>" class="form-control" placeholder="date for closed your exam" required="required" data-error="question is required.">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-md-10 m-auto">
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <label for="questions">Questions *</label>
                            <input id="questions" type="number" min="0" name="questions" class="form-control" placeholder="How many questions do the test have?" required="required" data-error="question is required.">
                        </div>
                    </div>
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <label for="time">Time for the Test *</label>
                            <input id="time" type="number" min="1" name="time" class="form-control" placeholder="Time for doing the Test (in min)" required="required" data-error="question is required.">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-md-10 m-auto">
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <label for="true_count">Count True Question *</label>
                            <input id="true_count" type="number" min="0" value="1.00" name="true_count" class="form-control" placeholder="How much is a correct question?" data-error="question is required." step=".01"/>
                        </div>
                    </div>
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <label for="wrong_discount">Discount Wrong Question *</label>
                            <input id="wrong_discount" type="number" min="0" value="0" name="wrong_discount" class="form-control" placeholder="How many questions do the test have?" data-error="question is required." step=".01" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 m-auto">
                        <div class="form-group text-center">
                            <input id="random" type="checkbox"  name="random" class="custom-checkbox" value="true" ">
                            <label for="random">Random Questions</label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10  m-auto ">
                    <div class="form-group border">
                        <label for="courses">Select Course</label>
                        <select class="selectpicker form-control" name="courses[]" id="courses" multiple aria-label="Courses select" required>
                            <?php
                            if($_SESSION['user']->getUser_type_id() == 2){
                                foreach($courses as $course){
                                    echo "<option value='".$course->getCourse_id()."'>".$course->getName()."</option>";
                                }
                            } elseif($_SESSION['user']->getUser_type_id() == 3){

                                foreach($courses as $course){
                                    if($course->getUser_create()->getUser_id() === $_SESSION['user']->getUser_id()){
                                        echo "<option value='".$course->getCourse_id()."'>".$course->getName()."</option>";
                                    }
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
                        <label for="description">Test Description *</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Write your test description..." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                    </div>
                </div>
            </div>
            <div class="hr-2"></div>
            <div class="row">
                <div class="col-md-4 m-auto text-center">
                    <input type="submit" class="btn btn-success btn-send  pt-2 btn-block" value="Next Step" >
                </div>
            </div>
        </div>
    </form>
</div>
