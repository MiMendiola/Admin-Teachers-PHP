<main id="login">
	<div class=" p-4 loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
		<h3>Sign in here</h3>
		<p class="text-center text-danger" id="notify"></p>
		<form id="loginForm" action="<?php echo URL;?>login/login" method="post">
			<div class="inputBox">
				<input id="email" type="email" name="email" placeholder="Email" required />
				<input id="pass" type="password" name="pass" placeholder="Password" required />
				<input id="valid" type="hidden" name="valid" value="<?php echo URL; ?>"/>
				<!-- <div class=" m-auto pl-5 pb-4 form-check">
					<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
					<label class="form-check-label" for="flexCheckDefault">
						Remember me
					</label>
				</div> -->
			</div> 
			<input type="submit" id="btn-login" value="Login">
		</form> 
		<a href="#" data-bs-toggle='modal' data-bs-target="#fp">Forget Password<br> </a>
	</div>
</main>


<!-- Modal -->
<div class="modal fade" id="fp" data-url='<?php echo URL ;?>' data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Restore Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <p>Please Write your email.</p>
	  	<div class="input-group">
			 <span class="input-group-text  bg-primary"><i
                        class="bi bi-envelope text-white"></i></span>
            <input type="email" id="fmail" name="fmail" class="form-control" placeholder="Your email" value="" required />           
        </div>
		<div class="text-center mt-4 mb-0">
		<button id="forgotP" class="btn btn-info"> Recover </button>

		</div>
		</div>
      <div class="modal-footer m-auto">
      </div>
    </div>
  </div>
</div>
