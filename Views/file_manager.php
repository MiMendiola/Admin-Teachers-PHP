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
            <div class="row col-md-10 m-auto">
                <div class="col-md-4 m-auto">
                    <div class="form-group">
                        <label for="questions">Questions *</label>
                        <input id="questions" type="number" min="0" name="questions" class="form-control" placeholder="How many questions does the test have?" required="required" data-error="question is required.">
                    </div>
                </div>
                <div class="col-md-4 m-auto">
                    <div class="form-group">
                        <label for="date">Date Opened *</label>
                        <input id="date" type="datetime-local" min="<?php echo date('Y-m-d')."T".date("H:m"); ?>" name="date" class="form-control" placeholder="date for public your exam" required="required" data-error="question is required.">
                    </div>
                </div>
                <div class="col-md-4 m-auto">
                    <div class="form-group">
                        <label for="time">Time for the Test *</label>
                        <input id="time" type="number" min="1" name="time" class="form-control" placeholder="Time for doing the Test (in min)" required="required" data-error="question is required.">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10  m-auto ">
                    <div class="form-group border">
                        <label for="students">Select Course</label>
                        <select class="selectpicker form-control" id="students" multiple aria-label="Student select">
                            <?php 
                            foreach($courses as $course){
                                echo "<option value='".$course->getCourse_id()."'>".$course->getName()."</option>";
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
