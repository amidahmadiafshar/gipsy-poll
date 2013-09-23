<?php 
function getPercent($adad,$majmoe){
	if($majmoe == 0) {
		return 0;
	} else {
		return floor(($adad/$majmoe)*100);
	}
}
?>
<?php foreach ($answers as $a) { ?>
	<li class="list-group-item">
    	<div class="progress progress-striped active">
          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo getPercent($a['votes'],$poll['votes']); ?>%;">
            <span class="sr-only"><span class="label label-primary"><?php echo $a['answer'].' ('.getPercent($a['votes'],$poll['votes']).'%)'; ?></span></span>
          </div>
        </div>
    </li>
<?php } ?>
    <li class="list-group-item">
     <?php if($this->poll_model->poll_voted($poll['poll_id'])){ ?>
      <button class="btn btn-success btn-block" value="Vote" type="button" disabled="disabled">Your Vote Submited</button>
     <?php } else { ?>
      <center><a href="javascript:;" onclick="backToVote();">Back to vote</a></center>
     <?php } ?>
    </li>