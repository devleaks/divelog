<?php
/**
 * Upload dives.
 *
 * @package Divelog
 */

echo elgg_echo('divelog:upload:help'); ?>
<p/>
<p class="code">
"date","time","site","depth","duration","access","tags","buddies","notes"<br/>
"15/09/2013","15:45","Vodelée","36","38","1","vodelée","rackham, Ann","Belle plongée"<br/>
...
</p>

<div>
    <label><?php echo elgg_echo('divelog:upload:filename'); ?></label><br />
    <?php echo elgg_view('input/file', array('name' => 'filename')); ?>
</div>

<div>
    <label><?php echo elgg_echo('divelog:upload:ignorefirst'); ?></label><br />
    <?php echo elgg_view('input/checkbox', array('name' => 'ignorefirst')); ?>
</div>

<div>
    <label><?php echo elgg_echo('divelog:upload:encoding'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array('options' => array('UTF8', 'ISO-8859-1'), 'name' => 'encoding')); ?>
</div>

<div>
    <label><?php echo elgg_echo('divelog:upload:delimiter'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array('options' => array(',', ';', ':', '|'), 'name' => 'delimiter')); ?>
</div>

<div>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('divelog:upload:confirm'))); ?>
</div>
