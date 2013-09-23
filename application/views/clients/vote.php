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