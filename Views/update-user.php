<div class="text-center">
    <h3 class="text-primary"><?php echo $title; ?></h3>
</div>
<div class="p-4">
    <form action="<?php echo $user->getHash();?>" id="<?php echo $type;?>-user" method="POST"  enctype="multipart/form-data">
        
    <div class="input-group mb-4">
            <span class="input-group-text bg-primary"><i
                    class="bi bi-camera-fill text-white"></i></span>
            <input class="form-control col-md-5" placeholder="Your photo" type="file" value="NULL" id="photo">
    </div>

        <div class="input-group mb-4">
            <span class="input-group-text bg-primary"><i
                    class="bi bi-person-plus-fill text-white"></i></span>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?php echo ($type == "update") ? $user->getName() : "";  ?>" required/>
            
            <span class=" ml-2  input-group-text bg-primary"><i
                    class="bi bi-person-plus-fill text-white"></i></span>
            <input type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" value="<?php echo ($type == "update") ? $user->getLast_name() : "";  ?>" required />
            <span class="input-group-text  ml-2 bg-primary"><i
                            class="bi bi-person-badge-fill text-white"></i></span>
            <input type="text" class="form-control" placeholder="Passport ID" id="passport" name="passport" value="<?php echo ($type == "update") ? $user->getPassport() : "";?>" required/>
        
     </div>

        <?php 
            if($type == "create"){
    ?>
        <div class="input-group mb-4">
            <span class="input-group-text bg-primary"><i
                    class="bi bi-key-fill text-white"></i></span>
            <input type="text" class="form-control" placeholder="Password" id="pass" value='<?php echo $random;?>' name="pass" disabled/>
            <span class="input-group-text ml-5 bg-primary"><i
                        class="bi bi-envelope text-white"></i></span>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo ($type == "update") ? $user->getEmail() : "";  ?>" required />           
        </div>
        <div class="input-group mb-4">
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

        <?php
            } elseif($type == "update") {
            ?>
                <div class="input-group ">
                    <span class="input-group-text bg-primary"><i
                            class="bi bi-key-fill text-white"></i></span>
                    <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" required/>
                    <span class="ml-5 input-group-text bg-primary"><i
                            class="bi bi-key-fill text-white"></i></span>   
                    <input type="password" class="form-control" id="c_pass" placeholder="Confirm Password" required/>
                </div>
                
                <div class="input-group mb-4">
                    <div class="col-md-7"></div>
                     <span id="pp-diferent" class='text-danger col-md-5 d-none'>The both passworts are different.</span>
                     <span id="pp-true" class='text-success col-md-5 d-none'>The password is Ok.</span>
                </div>


                <div class="input-group mb-4">
                    <span class="input-group-text bg-primary"><i
                        class="bi bi-envelope text-white"></i></span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo ($type == "update") ? $user->getEmail() : "";  ?>" required />
                </div>
                <?php if(isset($editAdmin)){
                    ?>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-primary"><i
                                class="bi bi-person-lines-fill text-white"></i></span>
                        <select class=" col-md-3 form-select" name="typeUser" id="typeUser" aria-label="Default select example">
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
				<input id="valid" type="hidden" name="valid" value="<?php echo URL; ?>"/>

        <div class="d-grid col-2 mx-auto">
            <input class="btn btn-primary" type="submit" value="Save Student" name="create"/>
        </div>  
        
    </form>
</div>