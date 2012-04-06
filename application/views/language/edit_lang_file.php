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
		<div class="box menu">
			<a href="<?php echo site_url('/language');?>"><?php echo $this->lang->line('language_home_link');?></a>&nbsp;|&nbsp;<a href="<?php echo site_url('/language/lang_list/'.$language);?>"><?php echo $this->lang->line('language_file_list_link');?></a>&nbsp;|&nbsp;<a href="#" id="new_file"><?php echo $this->lang->line('language_create_file_link');?></a>
			<div class="right"><?php echo $this->lang->line('language_lang_label');?>: <strong><?php echo $language;?></strong> <?php echo $this->lang->line('language_file_label');?>: <strong><?php echo $file;?></strong></div>
			<div class="clear"></div>
			<div id="create_file_form">
				<?php echo form_open(site_url('/language/create_file'));?>
					<p><?php echo $this->lang->line('language_create_file_info');?></p><br/>
					<input type="text" name="filename" value=""/>
					<input type="hidden" name="language" value="<?php echo $language;?>" />
					<input type="submit" name="create" value="<?php echo $this->lang->line('language_create_label');?>" />
				</form>
			</div>
		</div>
		<div class="left">
			<?php if(isset($dir)&&!empty($dir)):
				$this->load->view('language/dir_list_view');
			 endif; ?>
			<div class="clear"></div>
			<?php if(!empty($dir)&&count($dir)>1): ?>
			<div class="box language listyle">
				<p><b><?php echo $this->lang->line('language_edit_file_info');?></b></p>
				<ul>
				<?php foreach($dir as $d):
					if($d['dir']!=$language):?>
						<?php if(file_exists(APPPATH."language/{$d['dir']}/$file")): ?>
							<li><a href="<?php echo site_url('/language/lang_file/'.$d['dir'].'/'.$file);?>"><?php echo $d['dir'];?></a></li>
						<?php else: ?>
							<li class="no-float"><?php echo $this->lang->line('language_langfile_not_exist').$d['dir'];?><br/>
								<?php echo form_open(site_url('/language/create_file'));?>
									<input type="hidden" name="filename" value="<?php echo $file;?>" />
									<input type="hidden" name="language" value="<?php echo $d['dir'];?>" />
									<input type="hidden" name="language_refferer" value="<?php echo $language;?>" />
									<input type="submit" name="create" value="<?php echo $this->lang->line('language_create_label');?>"/>
								</form>
							</li>
						<?php endif;
					endif;
				endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
		<?php if($keys===FALSE && !empty($lang)): ?>
		<div class="box files">
			<div><?php echo $this->lang->line('language_first_time_info');?></div>
			<?php echo form_open(site_url('/language/update_all_keys'));?>
				<div>
					<input type="hidden" name="filename" value="<?php echo $file;?>" />
					<input type="hidden" name="language" value="<?php echo $language;?>" /><br/>
					<input type="submit" name="update" value="<?php echo $this->lang->line('language_yes_label');?>" />
				</div>
			</form>
			<p class="error"><?php echo $this->lang->line('language_first_time_warning');?></p>
		</div>
		<?php endif;
		if(isset($extra_keys) && !empty($extra_keys)): ?>
			<div class="box files">
				<div>
				<p><?php echo $this->lang->line('language_keys_db_warning');?></p>
					<?php echo form_open(site_url('/language/add_extra_keys'));?>
						<div>
							<input type="hidden" name="filename" value="<?php echo $file;?>" />
							<input type="hidden" name="language" value="<?php echo $language;?>" />
							<input type="submit" name="add_keys" value="<?php echo $this->lang->line('language_add_all_keys');?>" />
						</div>
					</form>
					<p class="error"><?php echo $this->lang->line('language_keys_file_warning');?></p>
					<a href="#" onclick="$('#extra_keys').toggle();"><?php echo $this->lang->line('language_show_keys');?></a>
				</div>
				<div id="extra_keys" style="display:none;">
					<ul>
						<?php foreach($extra_keys as $k): ?>
							<li>
								<?php echo $k;?> = "<?php echo $lang[$k];?>"
								<?php echo form_open(site_url('/language/add_one_key'));?>
									<div>
										<input type="hidden" name="filename" value="<?php echo $file;?>" />
										<input type="hidden" name="language" value="<?php echo $language;?>" />
										<input type="hidden" name="key" value="<?php echo $k;?>" />
										<input type="submit" name="add_key" value="<?php echo $this->lang->line('language_add_this_key');?>" />
									</div>
								</form>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<div class="box files">
		<?php if($this->config->item('comments')==1) { ?><a href="#" onclick="$('.comments').toggle();"><?php echo $this->lang->line('language_sh_comments');?></a><br/><?php } ?>
			<?php echo form_open(site_url('/language/save_language_file'));?>
			<div id="results"></div>
			<?php if(isset($keys)&&!empty($keys)) :?>
				<?php foreach($keys as $key) :?>
					<div class="row" id="row_<?php echo $key;?>">
						<label class="left"><?php echo $key;?> <?php if(is_array($lang)&&!array_key_exists($key,$lang)){ ?><small>(NEW!)</small><?php }?> : </label>
						<input type="button" class="delete_key right" value="<?php echo $this->lang->line('language_delete_key');?>" id="key_<?php echo $key;?>"/>
						<?php if(isset($pattern) && array_key_exists($key,$pattern)){
							echo '<p class="pattern clear">'.$pattern[$key].'</p>';
						}?>
						<input type="text" value="<?php echo (is_array($lang) && array_key_exists($key,$lang)) ? htmlspecialchars(stripslashes($lang[$key])):'';?>" name="<?php echo $key;?>" size="89"/>
						<?php if(isset($comments)){ ?>
							<div class="comments"<?php echo ($this->config->item('comments_show')==1) ? '' : ' style="display:none;"';?>>
								<label class="left">Comment:</label><input class="comment left" type="text" name="comment_<?php echo $key;?>" size="50" value="<?php echo (is_array($comments) && array_key_exists($key,$comments)) ? $comments[$key] : ''; ?>" />
							</div>
						<?php } ?>
						<div class="clear"></div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<div id="extra-lang"></div>
			<div class="clear"></div>
			<br/>
			<input type="hidden" name="filename" value="<?php echo $file;?>" />
			<input type="hidden" name="language" value="<?php echo $language;?>" />
			<input type="button" name="add_new_key" id="add_new_key" value="<?php echo $this->lang->line('language_add_new_key');?>" />
			<input type="submit" name="change" value="<?php echo $this->lang->line('language_save_changes');?>"/>
		</form>
		</div>
		<div class="box clear">
			Created by <a href="http://codebusters.pl/en">Eliza Witkowska</a>
		</div>
	</div>
	
    <script>
    $(document).ready(function(){
        $("#add_new_key").click(function() { ///add click action for button
            var n = $('.ex_key').length+1; ///get lenght of new keys and values
            var m = $('.ex_val').length+1;
            //<![CDATA[
            $('<div class="row"><label><?php echo $this->lang->line('language_key');?> : </label><input class="ex_key" type="text" name="new_key_'+n+'" size="30" /><br/><label><?php echo $this->lang->line('language_translation');?>:</label><input class="ex_val" type="text" name="new_value_'+m+'" size="89" /><br/><div class="clear"></div></div>').appendTo('#extra-lang'); ///add input for new key
            //]]>
        });
        $('#create_file_form').hide();
        $("#new_file").click(function() { ///add click action for button
            $('#create_file_form').toggle();
        });
        $('#new_lang_form').hide();
        $("#new_lang").click(function() { ///add click action for button
            $('#new_lang_form').toggle();
        });
        $('.button_del').click(function(){
            var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
            return answer; // answer is a boolean
        });
        $('.delete_key').click(function(){
            var answer = confirm('<?php echo $this->lang->line('language_confirm_key_delete');?>');
            if(answer===true){
                var key_name = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('/language/remove_key');?>",
                    data: {'key':$(this).attr('id'),'filename':'<?php echo $file;?>','language':'<?php echo $language;?>'<?php echo ($this->config->item('csrf_protection') === TRUE) ? ', \'csrf_test_name\':\''.$this->security->get_csrf_hash().'\'' : '';?>},
                    success: function(msg){
                        if(msg.response==true){
                            var del = key_name.substr(4);
                            $("#row_"+del).remove();
                            //<![CDATA[
                            $("#results").append('<div class="msg">'+msg.msg+'</div>');
                            //]]>
                        }else if(msg.response==false){
                            //<![CDATA[
                            $("#results").append('<div class="error">'+msg.msg+'</div>');
                            //]]>
                        }
                    }
                });
            }else{
                return FALSE;
            }
        });
    });
    </script>
</body>
</html>
