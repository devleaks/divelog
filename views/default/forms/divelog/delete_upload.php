<?php
/**
 * Upload dives.
 *
 * @package Divelog
 */

$options = array(
	'type' => 'object',
	'subtype' => 'divelog_upload',
	'container_guid' => elgg_get_logged_in_user_guid(),
	'limit' => 0,
);

$uploads =  elgg_get_entities_from_metadata($options);

$upload_list = array();

foreach($uploads as $key => $upload)
	$upload_list[$upload->getGUID()] = date('d-m-Y G:h', $upload->date) . " (".$upload->count.")";

?>
<p/>
    <label><?php echo elgg_echo('divelog:upload:select_upload'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array('options_values' => $upload_list, 'name' => 'upload')); ?>
</div>

<div>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('divelog:upload:delete_upload'))); ?>
</div>
