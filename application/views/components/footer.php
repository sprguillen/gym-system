		<footer class="container mt-5">
			<p class="float-right"><a href="#">Back to top</a></p>
			<p>&copy; 2017-2018 HiTechnologies, Inc. &middot; <a clas="text-link" href="#">Privacy</a> &middot; <a href="#">Terms</a> 
                <?php if (isset($user_type) && $user_type === 'admin' ): ?>
                &middot; 
                <a href="<?php echo base_url('admin/add'); ?>">Add Admin</a></p>
                <?php endif; ?>
	  	</footer>
		<script type="text/javascript" src="<?php echo base_url("assets/js/ValidationMessage.js"); ?>"></script>
  	</body>
</html>
