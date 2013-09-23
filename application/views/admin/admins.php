	  <h2>Admins Management</h2>
      <?php echo form_open(base_url('index.php/admin/index/ajax_add_admin'),array('class'=>'form-add-admin','id'=>'admin_add_admin')); ?>
    	<table class="table table-striped">
          <thead>
            <tr>
              <th style="width:11px;">#</th>
              <th style="width:188px;">First Name</th>
              <th style="width:188px;">Last Name</th>
              <th style="width:188px;">Username</th>
              <th style="width:188px;">Email</th>
              <th style="width:100px;">Edit Polls</th>
              <th style="width:76px;">Add / Edit</th>
              <th style="width:66px;">Delete</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td style="width:11px;">+</td>
                <td style="width:188px;">
                  <input type="text" id="admin_add_admin_fname" name="admin_add_admin_fname" placeholder="Firs Name" class="form-control" />
                </td>
                <td style="width:188px;">
                  <input type="text" id="admin_add_admin_lname" name="admin_add_admin_lname" placeholder="Last Name" class="form-control" />
                </td>
                <td style="width:188px;">
                  <input type="text" id="admin_add_admin_username" name="admin_add_admin_username" placeholder="Username" class="form-control" />
                </td>
                <td style="width:188px;">
                  <input type="email" id="admin_add_admin_email" name="admin_add_admin_email" placeholder="Email" class="form-control" />
                </td>
                <td style="width:100px;"><select id="admin_add_admin_pro_admin" name="admin_add_admin_pro_admin" class="form-control"><option value="0">No</option><option value="1">Yes</option></select></td>
                <td style="width:76px;"><button class="btn btn-sm btn-success" type="button" name="admin_add_admin_submit" id="admin_add_admin_submit" value="Add" >Add</button></td>
                <td style="width:66px;"></td>
            </tr>
          </tbody>
        </table>
       </form>
       <?php $i=0; foreach($admins as $admin){ $i++; ?>
       <?php echo form_open(base_url('index.php/admin/index/ajax_edit_admin'),array('class'=>'form-edit-admin','id'=>'admin_edit_admin'.$i)); ?>
        <table class="table table-striped">
          <tbody>
              <tr>
                <td style="width:11px;"><?php echo $i; ?></td>
                <td style="width:188px;"><input type="text" id="admin_edit_admin_fname" name="admin_edit_admin_fname" placeholder="First Name" class="form-control" value="<?php echo $admin['fname']; ?>" /></td>
                <td style="width:188px;"><input type="text" id="admin_edit_admin_lname" name="admin_edit_admin_lname" placeholder="Last Name" class="form-control" value="<?php echo $admin['lname']; ?>" /></td>
                <td style="width:188px;"><input type="text" value="<?php echo $admin['username']; ?>" disabled="disabled" class="form-control" /></td>
                <td style="width:188px;"><input type="text" value="<?php echo $admin['email']; ?>" disabled="disabled" class="form-control" /></td>
                <td style="width:100px;"><select id="admin_edit_admin_pro_admin" name="admin_edit_admin_pro_admin" class="form-control"><option <?php if(!$admin['pro_admin']){ echo 'selected="selected"'; } ?> value="0">No</option><option <?php if($admin['pro_admin']){ echo 'selected="selected"'; } ?> value="1">Yes</option></select></td>
                <td style="width:76px;">
                <input class="form-control" type="hidden" name="admin_edit_admin_id" id="admin_edit_admin_id" value="<?php echo $admin['admin_id']; ?>" />
                <button class="btn btn-sm btn-success" type="button" name="admin_edit_admin_submit<?php echo $i; ?>" id="admin_edit_admin_submit<?php echo $i; ?>" value="Save" >Save</button>
                </td>
                <td style="width:66px;">
                		<input class="form-control" type="hidden" name="admin_del_admin_id" id="admin_del_admin_id" value="<?php echo $admin['admin_id']; ?>" />
                		<button class="btn btn-sm btn-danger" type="button" name="admin_del_admin_submit<?php echo $i; ?>" id="admin_del_admin_submit<?php echo $i; ?>" value="Delete" <?php if($admin['super_admin']){echo 'disabled="disabled"';} ?>>Delete</button>
                    <script>
						$("#admin_edit_admin_submit<?php echo $i; ?>").click(function(){
							loading(1);
							$(this).attr('disabled',true);
							var form = $("#admin_edit_admin<?php echo $i; ?>");
							form.css('cursor','wait');
							$.ajax( {
							  type: "POST",
							  url: form.attr( 'action' ),
							  data: form.serialize(),
							  success: function( response ) {
								form.css('cursor','default');
								alert(response);
								$("#admin_edit_admin_submit<?php echo $i; ?>").attr('disabled',false);
								loadAdmins();
							  }
							});
						});
					</script>
                    <script>
						$("#admin_del_admin_submit<?php echo $i; ?>").click(function(){
							var x=window.confirm("Are you sure?")
							if (x){
							  loading(1);
							  $(this).attr('disabled',true);
							  var form = $("#admin_edit_admin<?php echo $i; ?>");
							  form.css('cursor','wait');
							  $.ajax( {
								type: "POST",
								url: '<?php echo base_url('index.php/admin/index/ajax_del_admin'); ?>',
								data: form.serialize(),
								success: function( response ) {
								  form.css('cursor','default');
								  alert(response);
								  $("#admin_del_admin_submit<?php echo $i; ?>").attr('disabled',false);
								  loadAdmins();
								}
							  });
							}
						});
					</script>
                </td>
              </tr>
          </tbody>
        </table>
       </form>
       <?php } ?>
        <script>
			$(document).ready(function(){
				$("#admin_change_pass_submit").click(function(){
					loading(1);
					$("#response").html('').slideUp();
					$(this).attr('disabled',true);
					var form = $("#admin_change_pass");
					form.css('cursor','wait');
					$.ajax( {
					  type: "POST",
					  url: form.attr( 'action' ),
					  data: form.serialize(),
					  success: function( response ) {
						$("#response").html(response).slideDown();
						$("#admin_change_pass_submit").attr('disabled',false);
						form.css('cursor','default');
						loading(0);
					  }
					});
				});
				$("#admin_add_admin_submit").click(function(){
					loading(1);
					$(this).attr('disabled',true);
					var form = $("#admin_add_admin");
					form.css('cursor','wait');
					$.ajax( {
					  type: "POST",
					  url: form.attr( 'action' ),
					  data: form.serialize(),
					  success: function( response ) {
						form.css('cursor','default');
						alert(response);
						$("#admin_add_admin_submit").attr('disabled',false);
						loadAdmins();
					  }
					});
				});
			});
			function loadAdmins(){
				loading(1);
				$.ajax( {
				  type: "GET",
				  url: '<?php echo base_url('index.php/admin/index/ajax_load_admins'); ?>',
				  success: function( response ) {
					$("#admin_management").html(response);
					loading(0);
				  }
				});
			}
			function loading(l) {
				if(l){
					$("#tab_content").slideUp();
					$("#ajax_loading").fadeIn();
				} else {
					$("#ajax_loading").fadeOut();
					$("#tab_content").slideDown();
				}
			}
		</script>
