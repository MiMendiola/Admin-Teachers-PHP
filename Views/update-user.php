<?php
if(isset($_SESSION['user_view'])){
?>
    <div class="col-md-12 text-right">
        <a class="btn btn-info" href="<?php echo URL; ?>adminController/comeBack">
            <i class="fa fa-user"></i>
            Return at your Profile
        </a>
    </div>
<?php
}
?>
<div class="text-center">
    <h3 class="text-primary"><?php echo $title; ?></h3>
</div>
<div class="row col-md-12 m-auto">
    <form action="<?php echo $user->getHash();?>" id="<?php echo $type;?>-user" method="POST"  enctype="multipart/form-data">
        <div class="row">
            <div class="card shadow  col-md-3 ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Photo Profile</h6>
                </div>
                <div class="card-body">
                    <div class="photo-profile text-center mb-3">
                        <?php
                        if($type != "create"){
                            echo "<img width='50'  src='".URL. $user->getPhoto()."' class='img-profile rounded-circle' alt='profile' />";
                        } else {
                            echo "<img width='50'  src='".URL."assets/img/default.png' class='img-profile rounded-circle' alt='profile' />";
                        }
                        ?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-primary"><i
                                    class="bi bi-camera-fill text-white"></i></span>
                        <input class="form-control " placeholder="Your photo" type="file" value="NULL" id="photo">
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4 col-md-9 "  style="margin-bottom: 0 !important;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Info</h6>
                </div>
                <div class="card-body p-2 py-5">
                    <div class="input-group align-items-start mb-4">
                        <div class="col-md-4 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-plus-fill text-white"></i></span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?php echo ($type == "update") ? $user->getName() : "";  ?>" required/>
                        </div>
                        <div class="col-md-4 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-plus-fill text-white"></i></span>
                            <input type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" value="<?php echo ($type == "update") ? $user->getLast_name() : "";  ?>" required />
                        </div>

                        <div class="col-md-4 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-badge-fill text-white"></i></span>
                            <input type="text" class="form-control" placeholder="DNI...(123456789L)" id="passport" name="passport" value="<?php echo ($type == "update") ? $user->getPassport() : "";?>" required/>
                        </div>
                    </div>

                    <?php
                    if($type == "create"){
                        ?>
                        <div class="input-group align-items-start mb-4">
                            <div class="col-md-4 d-flex align-items-center mb-2">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-key-fill text-white"></i></span>
                                <input type="text" class="form-control" placeholder="Password" id="pass" value='<?php echo $random;?>' name="pass" disabled/>
                            </div>
                            <div class="col-md-8 d-flex align-items-center mb-2">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-envelope text-white"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo ($type == "update") ? $user->getEmail() : "";  ?>" required />
                            </div>
                        </div>
                        <div class="input-group align-items-start">
                            <div class="col-md-12 d-flex align-items-center mb-2">
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-lines-fill text-white"></i></span>
                                <select class=" col-md-3 form-select" name="typeUser" id="typeUser" aria-label="Default select example">
                                    <?php
                                    foreach($userType AS $key => $name){
                                        if($_SESSION['user']->getUser_type_id() == 3 && $key ==2 ){
                                            continue;
                                        }
                                        if($name == "student"){
                                            echo  "<option value='$key' selected>".ucfirst($name)."</option>";
                                        } else {
                                            echo  "<option value='$key'>".ucfirst($name)."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php
                    } elseif($type == "update") {
                    ?>
                    <div class="input-group align-items-start">
                        <div class="col-md-6 d-flex align-items-center mb-2">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-key-fill text-white"></i></span>
                            <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" required/>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-key-fill text-white"></i></span>
                            <input type="password" class="form-control" id="c_pass" placeholder="Confirm Password" required/>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="col-md-7"></div>
                        <span id="pp-diferent" class='text-danger col-md-5 d-none'>The both passworts are different.</span>
                        <span id="pp-true" class='text-success col-md-5 d-none'>The password is Ok.</span>
                    </div>


                    <div class="input-group align-items-start">
                        <div class="col-md-6 d-flex align-items-center mb-2">
                                <span class="input-group-text bg-primary"><i
                                            class="bi bi-envelope text-white"></i></span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo ($type == "update") ? $user->getEmail() : "";  ?>" required />
                        </div>
                        <div class="col-md-6 d-flex align-items-center mb-2">

                            <?php
                            if(isset($editAdmin)){
                            ?>
                            <span class="input-group-text bg-primary"><i
                                        class="bi bi-person-lines-fill text-white"></i></span>
                            <select class="  form-select" name="typeUser" id="typeUser" aria-label="Default select example">
                                <?php
                                foreach($userType AS $key => $name){
                                    if($_SESSION['user']->getUser_type_id() == 3 && $key ==2 ){
                                        continue;
                                    }
                                    if($user->getUser_type_id() == $key){
                                        echo  "<option value='$key' selected>".ucfirst($name)."</option>";
                                    } else {
                                        echo  "<option value='$key'>".ucfirst($name)."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <input id="valido" type="hidden" name="valid" value="<?php echo URL; ?>"/>
            <div class="row mt-4">
                <div class="d-grid col-2 mx-auto mb-4">
                    <input class="btn btn-primary" type="submit" value="Save Student" name="create"/>
                </div>
            </div>
        </div>
    </form>
</div>
