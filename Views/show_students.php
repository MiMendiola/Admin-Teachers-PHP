<div class="text-center">
    <h3 class="text-primary">Users Table</h3>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Passport</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Normal IP</th>
                        <th>User Login</th>
                        <th>Profile Photo</th> 
                        <th>Acctions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Passport</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Normal IP</th>
                        <th>User Login</th> 
                        <th>Profile Photo</th> 
                        <th>Acctions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        foreach($users AS $user){
                            echo "<tr>";
                            echo "<td>".$user->getUser_id()."</td><td>".$user->fullName()."</td><td>".$user->getPassport()."</td><td>".$user->getEmail()."</td><td>".$user->getUser_type_id()."</td><td>".$user->getNormal_ip()."</td>";
                            echo ($user->getFirstTime() == "0000-00-00") ? "<td>Not Loggin yet </td>" : "<td>". $user->getFirstTime() ."</td>";                            
                            echo ($user->getPhoto() != "") ? "<td><img width='50' height='50' class='rounded-circle' src='".URL.$user->getPhoto()."' </td>": "<td><img width='40' src='".URL."assets/img/default.png'/> </td>" ;                            
                            echo "<td><a href='".URL."main/updateStudent/".$user->getHash()."' class='btn btn-primary btn-sm' data-id='".$user->getUser_id()."' title='Edit User'> <span class='fa fa-edit'></span></a>";
                            if(($_SESSION['user']->getUser_type_id() == 3 && $user->getUser_type_id() == "Admin") || (isset($_SESSION['user_view']) && $_SESSION['user']->getUser_Id() == $user->getUser_id())){
                              echo "<button class='btn btn-danger btn-del btn-sm' title='Delete' disabled> <span class='fas fa-trash-alt'></span>";
                            } else {
                              echo "<button class='btn btn-danger btn-del btn-sm' data-bs-toggle='modal' data-bs-target='#deleteUser' title='Delete' data-id='".$user->getUser_id()."'> <span class='fas fa-trash-alt'></span>";
                            }
                            
                            if(!isset($_SESSION['user_view'])){
                                echo "</button><a class='btn btn-warning btn-sm' title='User View' href='".URL."AdminController/userView/".$user->getHash()."'><span class='fa fa-eye'></span></a>";
                              }
                            echo "</td>";
                             echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteUser" data-url='<?php echo URL ;?>' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure that you want to delet the User? 
      </div>
      <div class="modal-footer">
        <button type="button" id="yes" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
        <button type="button" id="cancel" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
