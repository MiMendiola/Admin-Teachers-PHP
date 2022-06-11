
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