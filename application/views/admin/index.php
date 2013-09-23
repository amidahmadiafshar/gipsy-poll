	  <?php 
	  
		  function getPercent($adad,$majmoe){
			  if($majmoe == 0) {
				  return 0;
			  } else {
				  return floor(($adad/$majmoe)*100);
			  }
		  }
		  
	  ?>
<div class="container">
  <h1><?php echo @$page_title; ?> <img id="ajax_loading" src="<?php echo base_url('assest/img/66.gif'); ?>" /></h1>
  <ul class="nav nav-tabs">
    <?php if($this->admin_model->is_super_admin()){ ?>
    <li class="active"><a href="#admin_management" data-toggle="tab">Admins Management</a></li>
    <?php } ?>
    <li <?php if(!$this->admin_model->is_super_admin()){echo 'class="active"';} ?>><a href="#polls_management" data-toggle="tab">Polls Management</a></li>
    <li><a href="#votes" data-toggle="tab">Votes</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li>
    <div id="logout_div"><span>logged as </span><b><?php echo $logged_admin['fname'].' '.$logged_admin['lname']; ?></b> <a href="javascript:;" id="admin_logout_submit">Log Out</a></div>
  </ul>
  <div class="tab-content" id="tab_content">
    <?php if($this->admin_model->is_super_admin()){ ?>
    <div class="tab-pane active" id="admin_management">
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
            <td style="width:188px;"><input type="text" id="admin_add_admin_fname" name="admin_add_admin_fname" placeholder="Firs Name" class="form-control" /></td>
            <td style="width:188px;"><input type="text" id="admin_add_admin_lname" name="admin_add_admin_lname" placeholder="Last Name" class="form-control" /></td>
            <td style="width:188px;"><input type="text" id="admin_add_admin_username" name="admin_add_admin_username" placeholder="Username" class="form-control" /></td>
            <td style="width:188px;"><input type="email" id="admin_add_admin_email" name="admin_add_admin_email" placeholder="Email" class="form-control" /></td>
            <td style="width:100px;"><select id="admin_add_admin_pro_admin" name="admin_add_admin_pro_admin" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select></td>
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
            <td style="width:100px;"><select id="admin_edit_admin_pro_admin" name="admin_edit_admin_pro_admin" class="form-control">
                <option <?php if(!$admin['pro_admin']){ echo 'selected="selected"'; } ?> value="0">No</option>
                <option <?php if($admin['pro_admin']){ echo 'selected="selected"'; } ?> value="1">Yes</option>
              </select></td>
            <td style="width:76px;"><input class="form-control" type="hidden" name="admin_edit_admin_id" id="admin_edit_admin_id" value="<?php echo $admin['admin_id']; ?>" />
              <button class="btn btn-sm btn-success" type="button" name="admin_edit_admin_submit<?php echo $i; ?>" id="admin_edit_admin_submit<?php echo $i; ?>" value="Save" >Save</button></td>
            <td style="width:66px;"><input class="form-control" type="hidden" name="admin_del_admin_id" id="admin_del_admin_id" value="<?php echo $admin['admin_id']; ?>" />
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
					</script></td>
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
    </div>
    <?php } ?>
    <div class="tab-pane <?php if(!$this->admin_model->is_super_admin()){echo 'active';} ?>" id="polls_management">
      <h2>Polls Management</h2>
      <ul class="nav nav-tabs">
        <?php foreach($polls as $poll){ ?>
        <li><a href="#poll<?php echo $poll['poll_id']; ?>" data-toggle="tab" title="<?php echo $poll['question']; ?>"><?php echo substr($poll['question'],0,10).'...'; ?></a></li>
        <?php } ?>
        <?php if($this->admin_model->is_pro_admin()){ ?>
        <li class="active"><a href="#add_poll" data-toggle="tab">+</a></li>
        <?php } ?>
      </ul>
      <div class="tab-content" id="tab_content2">
        <?php foreach($polls as $poll){ ?>
        <div class="tab-pane" id="poll<?php echo $poll['poll_id']; ?>"> <?php echo form_open(base_url('index.php/admin/index/ajax_edit_poll'),array('class'=>'form-edit-poll','id'=>'admin_edit_poll'.$poll['poll_id'])); ?> <br />
          <a href="<?php echo base_url('index.php/client/poll/question/'.$poll['poll_id']); ?>" class="btn btn-primary" target="_blank">View Poll</a>
          <a href="javascript:;" onclick="delPoll('<?php echo $poll['poll_id']; ?>')" class="btn btn-danger">Delete Poll</a>
          <br /><br />
          <label for="admin_edit_poll_question<?php echo $poll['poll_id']; ?>">Question : </label>
          <br />
          <input id="admin_edit_poll_question<?php echo $poll['poll_id']; ?>" name="admin_edit_poll_question<?php echo $poll['poll_id']; ?>" placeholder="Question" class="form-control" value="<?php echo $poll['question']; ?>" />
          <br />
          <br />
          <br />
          <label for="admin_edit_poll_answer<?php echo $poll['poll_id']; ?>">Answers : </label>
          <br />
          <?php $answers = $this->poll_model->get_answers(0,$poll['poll_id']);  ?>
          <?php foreach ($answers as $a) { ?>
            <input id="admin_edit_poll_answer<?php echo $poll['poll_id']; ?>" name="admin_edit_poll_answer<?php echo $poll['poll_id']; ?>[<?php echo $a['answer_id']; ?>]" placeholder="Answer" class="form-control" value="<?php echo $a['answer']; ?>" /><br />
            <div class="progress progress-striped active">
              <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo getPercent($a['votes'],$poll['votes']).'%'; ?>;">
                <span class="sr-only"><span class="label label-primary"><?php echo $a['answer'].' ('.getPercent($a['votes'],$poll['votes']).'%)'; ?></span></span>
              </div>
            </div>
          	<br /><br />
          <?php } ?>
          <br />
          <label for="admin_edit_poll_multi_select<?php echo $poll['poll_id']; ?>">Active Multi Select : </label>
          <br />
          <select id="admin_edit_poll_multi_select<?php echo $poll['poll_id']; ?>" name="admin_edit_poll_multi_select<?php echo $poll['poll_id']; ?>" class="form-control">
            <option <?php if($poll['multi_select'] == 0){echo 'selected="selected"'; } ?> value="0">No</option>
            <option <?php if($poll['multi_select'] == 1){echo 'selected="selected"'; } ?> value="1">Yes</option>
          </select>
          <br />
          <br />
          <br />
          <label for="admin_edit_poll_view_result<?php echo $poll['poll_id']; ?>">Result View Mode : </label>
          <br />
          <select id="admin_edit_poll_view_result<?php echo $poll['poll_id']; ?>" name="admin_edit_poll_view_result<?php echo $poll['poll_id']; ?>" class="form-control">
            <option <?php if($poll['view_result'] == 1){echo 'selected="selected"'; } ?> value="1">Always</option>
            <option <?php if($poll['view_result'] == 2){echo 'selected="selected"'; } ?> value="2">After Vote</option>
            <option <?php if($poll['view_result'] == 0){echo 'selected="selected"'; } ?> value="0">Never</option>
          </select>
          <br />
          <br />
          <br />
          <input class="btn btn-lg btn-success btn-block" type="hidden" name="admin_edit_poll_id" id="admin_edit_poll_id" value="<?php echo $poll['poll_id']; ?>" />
          <button class="btn btn-lg btn-success btn-block" type="button" name="admin_edit_poll_submit<?php echo $poll['poll_id']; ?>" id="admin_edit_poll_submit<?php echo $poll['poll_id']; ?>" value="Save" >Save</button>
          </form>
          <script>
				$("#admin_edit_poll_submit<?php echo $poll['poll_id']; ?>").click(function(){
					loading(1);
					$(this).attr('disabled',true);
					var form = $("#admin_edit_poll<?php echo $poll['poll_id']; ?>");
					form.css('cursor','wait');
					$.ajax( {
					  type: "POST",
					  url: form.attr( 'action' ),
					  data: form.serialize(),
					  success: function( response ) {
						form.css('cursor','default');
						alert(response);
						$("#admin_edit_poll_submit<?php echo $poll['poll_id']; ?>").attr('disabled',false);
						loadPolls();
					  }
					});
				});
			</script>
        </div>
        <?php } ?>
        <?php if($this->admin_model->is_pro_admin()){ ?>
        <div class="tab-pane active" id="add_poll"> <?php echo form_open(base_url('index.php/admin/index/ajax_add_poll'),array('class'=>'form-add-poll','id'=>'admin_add_poll')); ?> <br />
          <label for="admin_add_poll_question">Question : </label>
          <br />
          <input id="admin_add_poll_question" name="admin_add_poll_question" placeholder="Question" class="form-control" />
          <br />
          <br />
          <br />
          <label for="admin_add_poll_answer">Answers : </label>
          <br />
          <div id="admin_add_poll_answer_list">
            <input id="admin_add_poll_answer" name="admin_add_poll_answer[]" placeholder="Answer" class="form-control" />
          </div>
          <br />
          <a href="javascript:;" id="add_admin_add_poll_answer"><span class="label label-success">+ Add Answer</span></a><br />
          <br />
          <br />
          <label for="admin_add_poll_multi_select">Active Multi Select : </label>
          <br />
          <select id="admin_add_poll_multi_select" name="admin_add_poll_multi_select" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>
          <br />
          <br />
          <br />
          <label for="admin_add_poll_view_result">Result View Mode : </label>
          <br />
          <select id="admin_add_poll_view_result" name="admin_add_poll_view_result" class="form-control">
            <option value="1">Always</option>
            <option value="2">After Vote</option>
            <option value="0">Never</option>
          </select>
          <br />
          <br />
          <br />
          <button class="btn btn-lg btn-success btn-block" type="button" name="admin_add_poll_submit" id="admin_add_poll_submit" value="Add" >Add Poll</button>
          </form>
          <script>
				$(document).ready(function() {
					$("#add_admin_add_poll_answer").click(function(){
						$("#admin_add_poll_answer_list").append('<br /><input id="admin_add_poll_answer" name="admin_add_poll_answer[]" placeholder="Answer" class="form-control" /><a href="javascript:;" class="remove_admin_add_poll_answer" onclick="remove_admin_add_poll_answer($(this));"><span class="label label-danger">Remove</span></a>');
					});
				});
				function remove_admin_add_poll_answer(removelink){
					removelink.prev("input").remove();
					removelink.prev("br").remove();
					removelink.remove();
				}
				$("#admin_add_poll_submit").click(function(){
					loading(1);
					$(this).attr('disabled',true);
					var form = $("#admin_add_poll");
					form.css('cursor','wait');
					$.ajax( {
					  type: "POST",
					  url: form.attr( 'action' ),
					  data: form.serialize(),
					  success: function( response ) {
						form.css('cursor','default');
						alert(response);
						$("#admin_add_poll_submit").attr('disabled',false);
						loadPolls();
					  }
					});
				});
				function delPoll(pollid){
					var x=window.confirm("Are you sure?")
					if (x){
						loading(1);
						$.ajax( {
						  type: "POST",
						  url: '<?php echo base_url('index.php/admin/index/ajax_del_poll'); ?>',
						  data: {admin_del_poll : 'submit', admin_del_poll_id : pollid},
						  success: function( response ) {
							alert(response);
							loadPolls();
						  }
						});
					}
				}
				function loadPolls(){
					loading(1);
					$.ajax( {
					  type: "GET",
					  url: '<?php echo base_url('index.php/admin/index/ajax_load_polls'); ?>',
					  success: function( response ) {
						$("#polls_management").html(response);
						loading(0);
					  }
					});
				}
			</script> 
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="tab-pane" id="votes">
      <script src="<?php echo base_url('assest/js/jquery.dataTables.min.js'); ?>"></script>
      <h2>Votes</h2>
      <div id="votes_table"></div>
      <script>
        $(document).ready(function() {
			$('#votes_table').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"></table>' );
			$('#example').dataTable( {
				"aaData": [
				  <?php foreach($votes as $v) {
					  $ID = $v['vote_id'];
					  $Poll = '';
					  foreach ($polls as $p){
						  if($p['poll_id'] == $v['poll_id']) {
							  $Poll = $p['question'];
						  }
					  }
					  $Answer = '';
					  $Answers = $this->poll_model->get_answers();
					  foreach ($Answers as $a){
						  if($a['answer_id'] == $v['answer_id']) {
							  $Answer = $a['answer'];
						  }
					  }
					  $Note = $v['vote_note'];
					  $IPAddress = $v['ip_address'];
					  $Date = date('r',$v['time']);
				  ?>
					[ "<?php echo $ID; ?>", "<?php echo $Poll; ?>", "<?php echo $Answer; ?>", "<pre><?php echo $Note; ?></pre>", "<?php echo $IPAddress; ?>", "<?php echo $Date; ?>" ],
				  <?php } ?>
				],
				"aoColumns": [
					{ "sTitle": "ID" },
					{ "sTitle": "Poll" },
					{ "sTitle": "Answer" },
					{ "sTitle": "Note" },
					{ "sTitle": "IP Address" },
					{ "sTitle": "Date" },
				]
			} );   
			$("#example").addClass('table');
			$("input[aria-controls='example'], select[aria-controls='example']").addClass('form-control');
			$("#example_next").html('<span class="glyphicon glyphicon-chevron-right"></span>').css('cursor','pointer');
			$("#example_previous").html('<span class="glyphicon glyphicon-chevron-left"></span>').css('cursor','pointer');
		} );
      </script>
    </div>
    <div class="tab-pane" id="settings">
      <h2>Change Password</h2>
      <?php echo form_open(base_url('index.php/admin/index/ajax_change_pass'),array('class'=>'form-change-pass','id'=>'admin_change_pass')); ?>
      <label for="admin_change_pass_current_pass">Current Password : </label>
      <br />
      <input type="password" id="admin_change_pass_current_pass" name="admin_change_pass_current_pass" placeholder="Current Password" class="form-control" />
      <br />
      <br />
      <label for="admin_change_pass_new_pass">New Password : </label>
      <br />
      <input type="password" id="admin_change_pass_new_pass" name="admin_change_pass_new_pass" placeholder="New Password" class="form-control" />
      <br />
      <br />
      <label for="admin_change_pass_re_pass">Repeat Password : </label>
      <br />
      <input type="password" id="admin_change_pass_re_pass" name="admin_change_pass_re_pass" placeholder="Repeat Password" class="form-control" />
      <br />
      <br />
      <div id="response"></div>
      <button class="btn btn-lg btn-primary btn-block" type="button" name="admin_change_pass_submit" id="admin_change_pass_submit" value="Save" >Save</button>
      </form>
    </div>
  </div>
</div>
<div id="logout_response"></div>
<script>
	$(document).ready(function(){
		$("#admin_logout_submit").click(function(){
			$(this).attr('disabled',true);
			$.ajax( {
			  type: "GET",
			  url: '<?php echo base_url('index.php/admin/login/ajax_logout'); ?>',
			  success: function( response ) {
				$("#logout_response").html(response);
				$("#admin_logout_submit").attr('disabled',false);
			  }
			});
		});
	});
</script>