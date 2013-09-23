<?php if(!$this->poll_model->poll_voted($poll['poll_id'])) { echo form_open(base_url('index.php/client/poll/ajax_poll_vote'),array('class'=>'form-poll-vote','id'=>'client_poll_vote'.$poll['poll_id']));} ?>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo $page_title; ?> <span>(Select one<?php if($poll['type'] == 'checkbox'){ echo ' or more'; } ?>)</span></div>
      <ul class="list-group">
      <?php if($this->poll_model->poll_voted($poll['poll_id'])) { ?>
      	<?php 
			$data = array(
				'poll' => $poll,
				'answers' => $answers,
			);
			$this->load->view('clients/poll_result',$data);
		?>
      <?php } else { ?>
        <?php foreach ($answers as $a) { ?>
          <li class="list-group-item" onclick="<?php echo $poll['type']; ?>It('<?php echo $a['answer_id']; ?>');" id="answer<?php echo $a['answer_id']; ?>">
            <?php echo $a['answer']; ?>
          </li>
          <input type="<?php echo $poll['type']; ?>" value="<?php echo $a['answer_id']; ?>" name="client_poll_vote_answer[]" id="client_poll_vote_answer<?php echo $a['answer_id']; ?>" />
        <?php } ?>
        <li class="list-group-item">
          <textarea name="client_poll_vote_note" id="client_poll_vote_note" class="form-control" placeholder=" Extra note..."></textarea>
        </li>
        <li class="list-group-item">
          <input type="hidden" name="client_poll_vote_poll_id" id="client_poll_vote_poll_id" value="<?php echo $poll['poll_id']; ?>" />
          <button class="btn btn-success btn-block" value="Vote" type="button" name="client_poll_vote_submit" id="client_poll_vote_submit" onclick="submitVote();">Submit Vote</button>
         <?php if($this->poll_model->can_view_poll_result($poll['poll_id'])){ ?>
          <br /><center><a href="javascript:;" onclick="loadResult();">View Result.</a></center>
         <?php } ?>
        </li>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php if(!$this->poll_model->poll_voted($poll['poll_id'])) { echo '</form>'; ?>
<script>
	function checkboxIt(id){
		$("#answer"+id).toggleClass("active");
		$("#client_poll_vote_answer"+id).trigger('click');
	}
	function radioIt(id){
		$(".list-group-item").removeClass("active").filter("#answer"+id).addClass("active");
		$("#client_poll_vote_answer"+id).trigger('click');
	}
	function submitVote(){
		var form = $("#client_poll_vote<?php echo $poll['poll_id']; ?>")
		$(".panel").css('cursor','pointer');
		$(".list-group").slideUp();
		$.ajax( {
		  type: "POST",
		  url: form.attr( 'action' ),
		  data: form.serialize(),
		  success: function( response ) {
			  if(response == '1') {
				  alert('Your vote submited!');
				  loadResult();
			  } else {
				  alert('Please select answer and try again!');
				  $(".list-group").slideDown();
			  }
		  }
		});
	}
	function loadResult(){
		$(".list-group").slideUp();
		$.ajax( {
		  type: "POST",
		  data: { poll_id : "<?php echo $poll['poll_id']; ?>" },
		  url: '<?php echo base_url('index.php/client/poll/ajax_load_result'); ?>',
		  success: function( response ) {
			$(".list-group").html(response);
			$(".list-group").slideDown();
		  }
		});
	}
	function backToVote(){
		$(".list-group").slideUp();
		$.ajax( {
		  type: "POST",
		  data: { poll_id : "<?php echo $poll['poll_id']; ?>" },
		  url: '<?php echo base_url('index.php/client/poll/ajax_load_poll'); ?>',
		  success: function( response ) {
			$(".list-group").html(response);
			$(".list-group").slideDown();
		  }
		});
	}
</script>
<?php } ?>