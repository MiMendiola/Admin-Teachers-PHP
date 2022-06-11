<?php
?>
<div id="val" data-site="<?php echo URL;?>" class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 id='courseVista' data-id-course="<?php echo $course->getCourse_id();?>" class="h3 mb-0 text-gray-800">Course <?php echo $course->getName()?> </h1>
    </div>
<div class="row">
    <?php
        if(!empty($files)){
        foreach($files AS $file){
            $ext = explode(".", $file);
        ?>
            <div class=" m-2 card" style="width: 15rem;">
            <img  src="<?php echo (strpos($file, 'jpg') ||strpos($file, 'png') || strpos($file, 'jpeg') || strpos($file, 'webp')) ? URL. $course->getFolder() .'/'.$file : URL.$course->getImg();?>" class="card-img-top m-auto pt-3 w-50" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo "File from: ". $course->getName() ?></h5>
                <p class="card-text"><?php echo $file ?></p>
                <div class="row">
                    <a title="Download file"  href="<?php echo URL. $course->getFolder() .'/'.$file?>" download="<?php echo $file ?>" class="btn btn-success btn-lg  m-auto col-md-5 dw">
                        <span class="fa fa-download"></span>
                    </a> 
                <?php
                    if(in_array($ext[1], $extValid)){
                ?>
                        <span  title="View File" class="btn m-auto btn-info btn-lg col-md-5 sh" data-file="<?php echo $file ?>" data-url-file="<?php echo $course->getFolder() .'/'.$file?>" data-toggle="modal" data-target="#showFile">
                                <span class="fa fa-eye"></span>
                        </span>
                <?php } ?>
                </div>
            </div>
        </div>
    <?php
        }

    }
        if(!empty($course->getTests())){
            foreach($course->getTests() AS $test){
                if($test->getDate() <= date("Y-m-d H:i:s") && $test->getDateClose() >= date("Y-m-d H:i:s") && $test->getOpen() == 1){
                    //if((!is_null($test->getUserTest()['date_start']) || !empty($test->getUserTest()['date_start']))  || ( !empty($test->getUserTest()['score'])|| !is_null($test->getUserTest()['score'])) ){
                    if($test->getUserTest() != false){
                        ?>
                        <div class=" m-2 card border-2" style="width: 15rem;">
                            <img  src="<?php echo URL."assets/img/testImg.png" ?>" class="card-img-top m-auto pt-3 w-50" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "Test: ". $test->getName() ?></h5>
                                <p class="card-text"><?php echo "See the test result" ?></p>
                                <p class="card-text te"><?php echo "You finished it at: <b>".$test->getUserTest()['date_end'];?></b></p>
                                <div class="row">
                                    <a title="Download file"  href="<?php echo URL."TestController/viewResult/".$test->getHash()."/".$_SESSION['user']->getHash()."/".$course->getHash()?>" class="btn btn-primary btn-lg m-auto col-md-5 dw">
                                        Result
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class=" m-2 card border-danger shadow-lg border-2" style="width: 15rem;">
                            <img  src="<?php echo URL."assets/img/testImg.png" ?>" class="card-img-top m-auto pt-3 w-50" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "Test: ". $test->getName() ?></h5>
                                <p class="card-text"><?php echo "Time for the Test: <b>".$test->getTime()." Mins </b>" ?></p>
                                <p class="card-text te"><?php echo "Closed: <b>".$test->getDateClose();?></b></p>
                                <div class="row">
                                    <a title="Download file"  href="<?php echo URL. "TestController/preTest/".$course->getHash()."/".$test->getHash()?>" class="btn btn-success btn-lg  m-auto col-md-5 dw">
                                        Start
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } elseif($test->getOpen() == 0){
                    ?>
                    <div class=" m-2 card bg-light border-2" style="width: 15rem; opacity: 30%;">
                        <img  src="<?php echo URL."assets/img/testImg.png" ?>" class="card-img-top m-auto pt-3 w-50" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo "Test: ". $test->getName() ?></h5>
                            <p class="card-text"><?php echo "Time for the Test: <b>".$test->getTime()." Mins </b>" ?></p>
                            <p class="card-text te"><?php echo "Closed: <b>".$test->getDateClose();?></b></p>
                            <div class="row">
                            </div>
                        </div>
                    </div>
                    <?php
                }

                elseif ($test->getDateClose() < date("Y-m-d H:i:s")){
                    if($test->getUserTest() == false){
                    ?>
                    <div class=" m-2 card border-2" style="width: 15rem; opacity: 50%;">
                        <img  src="<?php echo URL."assets/img/testImg.png" ?>" class="card-img-top m-auto pt-3 w-50" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo "Test: ". $test->getName() ?></h5>
                            <p class="card-text bg-gradient-warning">You didn't take the Test.</p>
                            <p class="card-text te"><?php echo "Closed: <b>".$test->getDateClose();?></b></p>
                        </div>
                    </div>
                    <?php
                    } else {
                        ?>
                        <div class=" m-2 card border-2" style="width: 15rem;">
                            <img  src="<?php echo URL."assets/img/testImg.png" ?>" class="card-img-top m-auto pt-3 w-50" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "Test: ". $test->getName() ?></h5>
                                <p class="card-text"><?php echo "See the test result" ?></p>
                                <p class="card-text te"><?php echo "You finished it at: <b>".$test->getUserTest()['date_end'];?></b></p>
                                <div class="row">
                                    <a title="Download file"  href="<?php echo URL."TestController/viewResult/".$test->getHash()."/".$_SESSION['user']->getHash()."/".$course->getHash()?>" class="btn btn-primary btn-lg m-auto col-md-5 dw">
                                        Result
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
            }
        }

        if(empty($course->getTests()) && empty($files)){
        echo "<div class='m-auto p-5'>";
        echo "<h1 class='text-center'> This Course is Empty.</h1>";
        echo "<h5 class='text-center m-auto'>Talk with your teacher if you think that you have an error.</h5>";
        echo "</div>";
    }
    ?>
</div>
    <hr>
    <div class="text-center">
        <h3 class="text-primary">Forum</h3>
    </div>
<div class="row" id="foroHere">
  <!-- LOAD SCRIPTS FOR SPECIAL TEXT AREA -->

<?php
if(!is_null($forums)){
foreach($forums AS $foro){
?>

<div class="col-md-12 card border-1 border-dark mb-3">
  <div class="card-header py-3">
    <div class="d-flex flex-justify align-items-center mr-3">
    <img width="50" height="50"  class="img-profile rounded-circle" src="<?php echo URL. $foro->getUser()->getPhoto(); ?>" alt="Photo Profile">
        <div class="row">
          <div class="ml-2 fw-bolder">
        <?php echo $foro->getUser()->fullName(); ?>
        </div>
          <div  class=" pl-4 fst-italic text-gray-500 text-wrap">
          <?php echo $foro->getDate(); ?>
          </div>
        </div>
    </div>      
  </div>
    <div class="card-body">
        <?php echo $foro->getMsg(); ?>
        <hr>
        <?php
                if(is_array($foro->getReplay())){
                    foreach($foro->getReplay() AS $post){
                ?>
        <div class=" row text-justify col-md-12 d-flex flex-row mb-4">
            <div class="p-3 me-3 border center" style="border-radius: 15px; background-color: #fbfbfb;">
                <div class="d-flex flex-justify justify-content-end mr-3">
                    <div class="row text-right mr-2 mb-4">
                    <div class="ml-2 fw-bold">
                    <?php echo $post->getUser()->fullName(); ?>
                    </div>
                    <div  class=" pl-4 fst-italic text-gray-500 text-wrap">
                    <?php echo $post->getDate(); ?>
                    </div>
                    </div>
                    <img width="50" height="50" class="img-profile rounded-circle" src="<?php echo URL. $post->getUser()->getPhoto(); ?>" alt="Photo Profile">
                </div>  
                <?php echo $post->getMsg(); ?>
            </div>
        </div>

        <?php
                } //foreach replys
        }//if getReply is array
            elseif($foro->getReplay() != 0){
            ?>
            <div class=" row text-justify col-md-12 d-flex flex-row mb-4">
            <div class="p-3 me-3 border center" style="border-radius: 15px; background-color: #fbfbfb;">
                <div class="d-flex flex-justify justify-content-end mr-3">
                    <div class="row text-right mr-2 mb-4">
                    <div class="ml-2 fw-bold">
                    <?php echo $foro->getReplay()->getUser()->fullName(); ?>
                    </div>
                    <div  class=" pl-4 fst-italic text-gray-500 text-wrap">
                    <?php echo $foro->getReplay()->getDate(); ?>
                    </div>
                    </div>
                    <img width="60" height="60" class="img-profile rounded-circle" src="<?php echo URL. $foro->getUser()->getPhoto(); ?>" alt="Photo Profile">
                </div>  
                <?php echo $foro->getReplay()->getMsg(); ?>
            </div>
        </div>
        <?php                
                }
        ?>
    </div>  
    <div class="card mt-5">
      <div class="col-md-12">
          <form action="" method="POST"  data-r="<?php echo $foro->getId()?>" class="reply-post">
              <div class="row m-auto d-flex align-items-center text-center">
                      <div class="col-md-2">
                        <img  src="<?php echo URL.$_SESSION['user']->getPhoto();?>" alt="avatar 3" width="50" height="50" class="img-profile rounded-circle"></div>
                      <div class="d-flex flex-column col-md-8 mt-2 mb-2 ">
                        <textarea class="ml-2 form-control form-control-lg write-replay" id="write-replay-<?php echo $foro->getId()?>" placeholder="Type message"></textarea>
                      </div>
                      <div class="col-md-2"><button type="submit" id="btn-replay-<?php echo $foro->getId()?>" class="btn btn-none text-primary" href="#!"><i class="fas fa-paper-plane"></i></button></div>
                </div>
          </form>
      </div>
  </div>
</div>

  <?php
} //Foros foreach
}
  ?>
</div>
<div class="row mb-3">  
  <div class="card mt-5">
  <div class="card-header py-3">
    <h5 class="text-center">New Post</h5>     
  </div>
      <div class="col-md-12">
          <form action="" method="POST" id="new-post">
              <div class="row m-auto d-flex align-items-center text-center">
                      <div class="col-md-2"><img width="50" height="50" class="img-profile rounded-circle" src="<?php echo URL.$_SESSION['user']->getPhoto();?>" alt="avatar 3"></div>
                      <div class="d-flex flex-column col-md-8 mt-2 mb-2">
                        <textarea class="ml-2 form-control form-control-lg" id="write-new-post" placeholder="Type message"></textarea>
                      </div>
                      <div class="col-md-2"><button type="submit" id="btn-new-post" class="btn btn-none text-info"><i class="fas fa-paper-plane"></i></button></div>

                </div>
          </form>
      </div>
  </div>
</div>
<!-- MODAL VIEW -->
<div class="modal fade" id="showFile" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File</h5>
      </div>
      <div class="modal-body">
        <div id="showf"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</div>

<script src="https://js.nicedit.com/nicEdit-latest.js"
        type="text/javascript"> </script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
        bkLib.onDomLoaded(textAreaG);
    });
    function textAreaG() {
            nicEditors.allTextAreas()
        }
</script>