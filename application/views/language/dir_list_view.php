<div class="box language">
	<?php if(isset($dir)&&!empty($dir)){ ?>
   <p><b><?php $this->lang->line('language_title');?></b></p>
	<ul>
	<?php foreach($dir as $d){ ?>
      <li><a href="<?php echo site_url('/language/lang_list/'.$d['dir']);?>"><?php echo $d['dir'];?> (files: <?php echo $d['count'];?>)</a>
      <?php echo form_open(site_url('/language/delete_language'));?>
			<input type="hidden" name="language" value="<?php echo $d['dir'];?>" />
         <input type="submit" name="delete" value="<?php echo $this->lang->line('language_delete_lang');?>" class="button_del" />
		</form><p class="clear"></p></li>
	<?php } ?>
	</ul>
	<div class="clear"></div><br/>
	<?php } ?>
   <p><a href="#" id="new_lang"><?php echo $this->lang->line('language_create_lang');?></a></p>
   <div id="new_lang_form">
      <?php echo form_open(site_url('/language/create_new_language'));?>
			<div>
            <label><?php echo $this->lang->line('language_new_lang_info');?></label>
				<input type="text" name="language" />
            <input type="submit" name="create" value="<?php echo $this->lang->line('language_create_label');?>" />
			</div>
		</form>
	</div>
</div>
