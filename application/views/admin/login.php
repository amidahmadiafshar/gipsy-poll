<div class="container">
  <?php echo form_open(base_url('index.php/admin/login/ajax_login'),array('class'=>'form-signin','id'=>'admin_login')); ?>
    <h3 class="form-signin-heading"><?php echo @$page_title; ?></h3>
    <input name="admin_login_username" type="text" class="form-control" placeholder="Email address or Username" autofocus="" value="admin">
    <input name="admin_login_password" type="password" class="form-control" placeholder="Password" value="password">
    <div id="response"></div>
    <button class="btn btn-lg btn-primary btn-block" type="button" name="admin_login_submit" id="admin_login_submit" value="Sign in" >Sign in</button>
  </form>
</div>
<script>
	$(document).ready(function(){
		$("#admin_login_submit").click(function(){
			$("#response").html('').slideUp();
			$(this).attr('disabled',true);
			var form = $("#admin_login");
			form.css('cursor','wait');
			$.ajax( {
			  type: "POST",
			  url: form.attr( 'action' ),
			  data: form.serialize(),
			  success: function( response ) {
				$("#response").html(response).slideDown();
				$("#admin_login_submit").attr('disabled',false);
				form.css('cursor','default');
			  }
			});
		});
	});
</script>
