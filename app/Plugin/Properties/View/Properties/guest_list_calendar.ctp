<?php $this->loadHelper('Calendar');?>
<div class="js-guest-calendar-response js-guest-list-calender-block form-block full-calendar-block content">
<h2 class="well space textb text-20 ver-mspace "> <?php echo __l('Select Check in/Check out dates'); ?> </h2>

<ol class="calender-guest-list unstyled">
<?php
	$start_date['date'] = 1;
	$start_date['month'] = $guest_lists[0]['month'];
	$start_date['year'] = $guest_lists[0]['year'];
	static $week = 0;
	$next= $prev=1;
	foreach($guest_lists as $guest_list){
		if($guest_list['year']<=(date('Y')+1)):
?>
	<li class="calender-guest-list-month">
<?php	echo $this->Calendar->guest_list_month($guest_list['year'], $guest_list['month'], $guest_list['data'], $start_date, $week); ?>
</li>
<?php
	 else:
	$next=0;
		endif;
	} ?>
</ol>
<div class="guest-list-prev"> 
<?php 

$prev_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest_list',
            'month' => $guest_lists[0]['month'],
            'year' => $guest_lists[0]['year'] - 1,
            'property_id' => $guest_lists[0]['id'],
        ) , true);
        echo "<span class='text-24 textb prev {\"url\":\"$prev_url\"} js-guest-calender-prev ui-datepicker-prev ui-corner-all'> <i class=' icon-chevron-left cur'></i> </span>";
?>
</div>
<div class="guest-list-next"> 
<?php 
		if($next):
		$next_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest_list',
            'month' => $guest_lists[0]['month'],
            'year' => $guest_lists[0]['year'] + 1,
            'property_id' => $guest_lists[0]['id'],
        ) , true);
        echo " <span class='text-24 textb next {\"url\":\"$next_url\"} js-guest-calender-next ui-datepicker-next ui-corner-all'> <i class=' icon-chevron-right cur'></i> </span>";
		else:
		$next_url='';
		endif;
?>

</div>

	</div>