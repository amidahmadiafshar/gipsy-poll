      <?php 
	  
		  function getPercent($adad,$majmoe){
			  if($majmoe == 0) {
				  return 0;
			  } else {
				  return floor(($adad/$majmoe)*100);
			  }
		  }
		  
	  ?>
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
          <?php $answers = $this->poll_model->get_answers(0,$poll['poll_id']); ?>
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
