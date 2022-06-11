<?php
?>

<div id="val" data-site="<?php echo URL;?>" class="container-fluid mb-3">
    <div class="row text-justify">
        <div class="card p-4 col-md-10 m-auto">
            <div class="card-body">
                <p class="text-black">
                    You are about to start the test: <b><?php echo $test->getName() ?></b>.
                </p>
                <p class="text-danger">
                    Please <b>read carefully this description and the description</b> that the teacher put on the test.
                </p>
                <p>
                    Once you enter the test <b>you will not be able to go back</b>.
                    A counter will appear with the time you have to take the test.
                    If the time expires, automatically the test will be sent with what you have done so far.
                </p>
                <p>
                    During the test you will <b>not be able to perform the actions of copying and pasting text</b>.
                    It is also <b>not allowed to leave the test tab</b>, otherwise the teacher will be alerted.
                </p>
                <p>
                    You will have:<b> <?php echo $test->getTime() ?> minutes </b> to complete this test.
                </p>
                <p>
                    This test has: <b> <?php echo $test->getTotalQuestions() ?> </b> Mixed exercises.
                </p>
                <p class="font-italic">
                    <?php echo $test->getDescription() ?>
                </p>
            </div>
            <div class="card-footer text-center">
                <a href="<?php echo URL."TestController/test/".$course->getHash()."/".$test->getHash(); ?>" class="btn btn-success" id="startTest"> Start Test</a>
            </div>
        </div>
    </div>
</div>
