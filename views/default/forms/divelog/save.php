<?php
/**
 * Edit / add a divelog
 *
 * @package Divelog
 */
// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$dive_site = elgg_extract('dive_site', $vars, '');
$dive_date = elgg_extract('dive_date', $vars, 0);
$dive_start_time = elgg_extract('dive_start_time', $vars, 0);
$dive_depth = elgg_extract('dive_depth', $vars, '');

$units = elgg_extract('units', $vars, get_user_units());

$dive_duration = elgg_extract('dive_duration', $vars, '');
$dive_buddies = elgg_extract('dive_buddies', $vars, '');
$dive_briefing = elgg_extract('dive_briefing', $vars, '');
$dive_debriefing = elgg_extract('dive_debriefing', $vars, '');
$dive_media = elgg_extract('dive_media', $vars, '');
$tags = elgg_extract('tags', $vars, '');

$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$shares = elgg_extract('shares', $vars, array());

$dive_in_future = ( ($dive_date + $dive_start_time*60) > time());
?>
<div>
    <label><?php echo elgg_echo("divelog:site"); ?></label><br />
    <?php
	if (elgg_is_active_plugin('elgg_tokeninput')) {
		echo elgg_view('input/tokeninput', array(
											'name' => 'dive_site',
											'value' => $dive_site,
											'callback' => 'tokenize_dive_sites',
											'strict' => false,
											'multiple' => false,
											'style' => 'width:100%;',
		));
	} else {
		echo elgg_view('input/text',array('name' => 'dive_site', 'value' => $dive_site));
	}?>
</div>

<div>
<!--
<?php //echo elgg_view("event_calendar/input/date_local",array('timestamp'=>TRUE, 'autocomplete'=>'off','class'=>'event-calendar-compressed-date','name' => 'dive_date','value'=>$dive_date));?>
-->
    <label><?php echo elgg_echo("divelog:date"); ?></label><br />
    <?php echo elgg_view("input/date",array('name' => 'dive_date','value'=>($dive_date+86400))); // TO BE CHECKED!! ?>
	<?php echo elgg_view("input/timepicker",array('name' => 'dive_start_time','value'=>$dive_start_time));?>
</div>

<div>
    <label><?php echo elgg_echo("divelog:depth") . " (". elgg_echo("divelog:in") . " " . elgg_echo("divelog:depth_".$units) .")"; ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'dive_depth', 'value' => $dive_depth, 'maxlength' => 20)); ?>
</div>

<div>
    <label><?php echo elgg_echo("divelog:duration") . " (". elgg_echo("divelog:in") . " " . elgg_echo("divelog:duration_unit") .")"; ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'dive_duration', 'value' => $dive_duration, 'maxlength' => 20)); ?>
</div>

<div>
    <label><?php echo elgg_echo("divelog:buddies"). " (". elgg_echo("divelog:buddies_hint") . ")";; ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'dive_buddies', 'value' => $dive_buddies)); ?>
</div>

<div>
    <?php echo elgg_view('input/checkbox',array('name' => 'dive_media',
		'checked' => $dive_media ? $dive_media : false)); ?>
    <label><?php echo elgg_echo("divelog:media"); ?></label>
</div>

<div>
<?php
if($dive_in_future) {
	echo "<label>".elgg_echo("divelog:briefing")."</label><br />";
    echo elgg_view('input/longtext',array('name' => 'dive_briefing', 'value' => $dive_briefing));

	// we do not allow to record post data comments, but we pass the hidden field in case someone already recorded something in it.
    echo elgg_view('input/hidden',array('name' => 'dive_debriefing', 'value' => $dive_debriefing));
} else {
	// we no longer allow to edit pre dive comments
	if($dive_briefing) {
		echo "<label>".elgg_echo("divelog:briefing")."</label><br />";
	    echo elgg_view('output/longtext',array('name' => 'dive_briefing', 'value' => $dive_briefing));
	}
	// we pass the hidden field with existing data in it. (note disabled longtext field does not seem to work.)
    echo elgg_view('input/hidden',array('name' => 'dive_briefing', 'value' => $dive_briefing));
	
	echo "<label>".elgg_echo("divelog:debriefing")."</label><br />";
    echo elgg_view('input/longtext',array('name' => 'dive_debriefing', 'value' => $dive_debriefing));
}
?>
</div>

<div>
    <label><?php echo elgg_echo("divelog:tags"); ?></label><br />
    <?php echo elgg_view('input/tags',array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>