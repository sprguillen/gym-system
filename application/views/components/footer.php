		<footer class="container mt-5">
			<p class="float-right"><a href="#">Back to top</a></p>
			<p>&copy; 2017-2018 HiTechnologies, Inc. &middot; 
            <?php if (isset($user_type) && $user_type === 'admin' ): ?>
                &middot; 
                <a href="<?php echo base_url('admin/add'); ?>">Add Admin</a></p>
            <?php endif; ?>
            <?php if ($this->session->userdata('logged_in')['account_type'] === 'Admin'
        			&& $user_type !== 'admin'): ?>
				<a class="text-info btn-sm mr-2" data-toggle="modal" data-target="#adminModeModal" href="#"><i class="fa fa-lock"></i> Enter Admin Mode</a>
            <?php endif; ?>
	  	</footer>
	  	<div class="modal fade" id="adminModeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title text-danger" id="exampleModalLabel">Enter Administrator Mode</h5>
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                </button>
		            </div>
		            <div class="modal-body">
		                <div class="form-group">
		                    <label for="username">Email username</label>
		                    <input type="email" class="form-control" id="admin-mode-user" aria-describedby="emailHelp" placeholder="Enter username">
		                </div>
		                <div class="form-group">
		                    <label for="password">Enter password</label>
		                    <input type="password" class="form-control" id="admin-mode-pass" aria-describedby="emailHelp" placeholder="Enter password">
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger submitAdmin">Submit</button>
		                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
		            </div>
		        </div>
		    </div>
		</div>
		<script type="text/javascript" src="<?php echo base_url("assets/js/ValidationMessage.js"); ?>"></script>
  	</body>
</html>
