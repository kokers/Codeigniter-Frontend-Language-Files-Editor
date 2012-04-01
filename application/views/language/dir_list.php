<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="cache-control" content="no-cache"/>
	<link href="<?php echo base_url();?>css/style.css" type="text/css" rel="stylesheet"/>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
	<div id="wrapper">
		<?php if($this->session->flashdata('error')): ?>
			<div class="error">
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php elseif($this->session->flashdata('msg')): ?>
			<div class="msg">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		<?php endif; ?>
		<?php $this->load->view('language/dir_list_view'); ?>
		<div class="box clear">
			Created by <a href="http://codebusters.pl/en">Eliza Witkowska</a>
		</div>
	</div>
	
	<script>
	$(document).ready(function(){
		$('.button_del').click(function(){
			var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
			return answer; // answer is a boolean
		});
		$('#new_lang_form').hide();
		$("#new_lang").click(function() { ///add click action for button
			$('#new_lang_form').toggle();
		});
   });
	</script>
</body>
</html>
