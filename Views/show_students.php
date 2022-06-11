<div class="text-center">
    <h3 class="text-primary">Users Table</h3>
</div>

<?php
?>
  <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>DNI</th>
                  <th>Email</th>
                  <th>User Type</th>
                  <th>Normal IP</th>
                  <th>User Login</th>
                  <th>Account Status</th>
                  <th>Acctions</th>
              </tr>
          </thead>
          <tfoot>
              <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>DNI</th>
                  <th>Email</th>
                  <th>User Type</th>
                  <th>Normal IP</th>
                  <th>User Login</th>
                  <th>Account Status</th>
                  <th>Acctions</th>
              </tr>
          </tfoot>
          <tbody>
              <?php 
                  foreach($users AS $user){
                      echo "<tr>";
                      //echo ($user->getPhoto() != "") ? "<td><img width='50' height='50' class='rounded-circle' src='".URL.$user->getPhoto()."' </td>": "<td><img width='40' src='".URL."assets/img/default.png'/> </td>" ;
                      echo "<td>".$user->getUser_id()."</td><td>";
                      ?>
                          <div class="d-flex align-items-center">
                              <img
                                      width="50"
                                      height="50"
                                      src="<?php echo ($user->getPhoto() != "") ? URL.$user->getPhoto() : URL."assets/img/default.png"?>"
                                      alt="Image Profile"
                                      class="img-profile rounded-circle"
                              />
                              <div class="ms-3">
                                  <p class=" mb-1"><?php echo $user->fullName()?></p>
                              </div>
                          </div>
              <?php
                   echo "</td>";

                    echo "</td>";

                        echo "<td>".$user->getPassport()."</td><td>".$user->getEmail()."</td><td>".$user->getUser_type_id()."</td><td>".$user->getNormal_ip()."</td>";
                      echo ($user->getFirstTime() == "0000-00-00") ? "<td>Not Loggin yet </td>" : "<td>". $user->getFirstTime() ."</td>";
                      echo ($user->openAcount()) ? "<td> <span class='bg-success pl-lg-2 pr-lg-2 rounded text-light'>Open</span></td>" : "<td> <span class='bg-dark text-white pl-lg-2 pr-lg-2 rounded'>Closed</span> </td>";
                      echo "<td>";
                      //This if compare if you are a teacher and the other is an admin, or if exist user view and user to execute is yourself
                      if(($_SESSION['user']->getUser_type_id() == 3 && $user->getUser_type_id() == "Admin") || (isset($_SESSION['user_view']) && $_SESSION['user']->getUser_Id() == $user->getUser_id())){
                          echo "<button  class='btn btn-primary btn-sm' title='Edit User' disabled> <span class='fa fa-edit'></span></button>";
                          echo "<button class='btn btn-danger btn-del btn-sm' title='Delete' disabled> <span class='fas fa-trash-alt'></span>";
                            if($_SESSION['user']->getUser_type_id() == 3 && $user->getUser_id() === $_SESSION['user']->getUser_id()){
                                if($user->openAcount()){
                                    echo "<button class='btn btn-success btn-op btn-sm' title='Open and Closed Account' disabled> <span class='fa fa-lock-open'></span>";

                                } else {
                                    echo "<button class='btn btn-secondary btn-op btn-sm' title='Open and Closed Account' disabled> <span class='fa fa-lock'></span>";
                                }
                            }

                      } else {
                          echo "<a href='".URL."main/updateStudent/".$user->getHash()."' class='btn btn-primary btn-sm' data-id='".$user->getUser_id()."' title='Edit User'> <span class='fa fa-edit'></span></a>";
                          echo "<button class='btn btn-danger btn-del btn-sm' data-bs-toggle='modal' data-bs-target='#deleteUser' title='Delete' data-id='".$user->getUser_id()."'> <span class='fas fa-trash-alt'></span>";
                              if($user->openAcount()){
                                  echo "<button class='btn btn-success btn-op btn-sm' title='Open and Closed Account' data-id='".$user->getUser_id()."'> <span class='fa fa-lock-open'></span>";

                              } else {
                                  echo "<button class='btn btn-secondary btn-op btn-sm' title='Open and Closed Account' data-id='".$user->getUser_id()."'> <span class='fa fa-lock'></span>";
                              }
                      }

                      if(!isset($_SESSION['user_view']) && $_SESSION['user']->getUser_id() != $user->getUser_id()){
                          if(($_SESSION['user']->getUser_type_id() == 3 || $_SESSION['user']->getUser_type_id() == 2) && $user->getUser_type_id() != "Admin"){
                              echo "</button><a class='btn btn-warning btn-sm' title='User View' href='".URL."AdminController/userView/".$user->getHash()."'><span class='fa fa-eye'></span></a>";
                          }
                        }
                      echo "</td>";
                        echo "</tr>";
                  }
              ?>
          </tbody>
      </table>
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
