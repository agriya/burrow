<?php /* SVN: $Id: $ */ ?>
<div class="ips index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('IPs');?></li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<?php echo $this->element('paging_counter');?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc span2"><?php echo __l('Actions');?></th>
        <th class="sep-right dc"><?php echo $this->Paginator->sort('created');?></th>
        <th class="sep-right"><?php echo $this->Paginator->sort( 'ip',__l('IP'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort('city_id');?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort('state_id');?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort('country_id');?></th>
        <th class="sep-right"><?php echo $this->Paginator->sort('latitude');?></th>
        <th class="sep-right"><?php echo $this->Paginator->sort('longitude');?></th>
    </tr></thead><tbody>
<?php
if (!empty($ips)):

$i = 0;
foreach ($ips as $ip):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
					
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $ip['Ip']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
							 </span>
                            </td>
		<td class="dc"><?php echo $this->Html->cDateTime($ip['Ip']['created']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['ip']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['City']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['State']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['Country']['name']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['latitude']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['longitude']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No IPs available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>

<?php if (!empty($ips)) { ?>
<div class="js-pagination pagination pull-right no-mar mob-clr dc">
<?php 	    echo $this->element('paging_links');  ?>
</div>	
<?php 	} ?>
</div>
