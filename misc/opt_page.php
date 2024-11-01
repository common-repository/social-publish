<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
<h2>Glue Labs Social Publish</h2>
<form name="form" action="" method="post">
  <p>This plugin allow you to integrate social functions in you blog.<br />
  Use this special string to retrieve data:
  <ul>
      <li>%t% : current post title</li>
      <li>%l% : current post link</li>
  </ul></p>

<table class="form-table">
	<tr>
            <th colspan="3" ><h3>Facebook</h3></th>
        </tr> 
        <tr>
            <td>Secret facebook mail<br /><i>Retrieve it from <a href="http://www.facebook.com/mobile" target="_blank">Your facebook account</a></i></td>
            <td> <input name="social_publish[secret_fb_mail]" type="text" value="<?php echo $options['social_publish']['secret_fb_mail'] ?>" class="regular-text code" /></td>
        </tr>
        <tr>
            <td>Write to dashboard on publishing new posts</td>
            <td><input type="checkbox" name="social_publish[f_on_publishing]"  <?php if($options['social_publish']['f_on_publishing']==TRUE)echo 'checked="checked"';?> /></td>
        </tr>
        <tr>
            <td>Phrase to write on publishing new posts</td>
            <td><input name="social_publish[f_on_publishing_phrase]" type="text" value="<?php echo $options['social_publish']['f_on_publishing_phrase'] ?>" class="regular-text code" /></td>
        </tr>
        <tr>
            <td>Write to dashboard on updating published posts</td>
            <td><input type="checkbox" name="social_publish[f_on_update]"  <?php if($options['social_publish']['f_on_update']==TRUE)echo 'checked="checked"';?> /></td>
        </tr>
        <tr>
            <td>Phrase to write on updating published posts</td>
            <td><input name="social_publish[f_on_update_phrase]" type="text" value="<?php echo $options['social_publish']['f_on_update_phrase'] ?>" class="regular-text code" /></td>
        </tr>
	
</table>
<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
  </form>
</div>

