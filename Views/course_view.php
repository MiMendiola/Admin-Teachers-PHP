<div id="val" data-site="<?php echo URL;?>" class="container-fluid">



<div class="row m-auto">
    <?php
        if(!empty($files)){
        foreach($files AS $file){
            $ext = explode(".", $file);
      ?>      
            <div class=" m-2 card" style="width: 15rem;">
            <img src="<?php echo URL.$course->getImg()?>" class="card-img-top m-auto pt-3 w-50" alt="...">
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
                        <span  title="View File" class="btn m-auto btn-warning btn-lg col-md-5 sh" data-file="<?php echo $file ?>" data-url-file="<?php echo $course->getFolder() .'/'.$file?>" data-toggle="modal" data-target="#showFile">
                                <span class="fa fa-eye"></span>
                        </span>
                <?php } ?>
                </div>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<div class='m-auto p-5'>";
        echo "<h1 class='text-center'> This Course is Empty.</h1>";
        echo "<h5 class='text-center m-auto'>Talk with your teacher if you think that you have an error.</h5>";
        echo "</div>";

    }
    ?>

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