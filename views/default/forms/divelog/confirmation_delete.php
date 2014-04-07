<?php
/**
 * Upload divelog creation report view. Prints a nice table of all the created divelogs.
 *
 */

?>
<input type="hidden" name="confirm" id="confirm" value="1">
<input type="hidden" name="upload" id="confirm" value="<?php echo $vars["upload"]; ?>">
<?php
echo $vars['report'];
echo elgg_view('input/securitytoken');
echo elgg_view('input/submit', array('value' => elgg_echo('divelog:upload:delete_divelogs')));
?>
