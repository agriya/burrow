<?php /* SVN: $Id: admin_permission.ctp 2999 2009-12-14 09:59:04Z siva_063at09 $ */ ?>
<div class="userTypes index js-response">
	<table class="list">
		<tr>
			<th class="alias"><?php echo __l('Alias'); ?></th>
			<?php 
			$roles_count=count($roles);
			foreach($roles as $role)
			{ ?>
			<th class="role-name"><?php echo $role['Role']['name']; ?></th>
			<?php }?>
		</tr>
		<?php
		if (!empty($aclLinks)):
			$controllers_arr=array();
			foreach($aclLinks as $aclLink)
			{
				$controllers_arr[]=$aclLink['AclLink']['controller'];
			}
			$controllers_arr=array_unique($controllers_arr);
			sort($controllers_arr);
			foreach($controllers_arr as $controller){ ?>
				<tr class="js-show-details inactive-row  up-arrow" id="<?php echo $controller; ?>">
					<td  colspan="<?php echo $roles_count+1; ?>"><?php echo $controller; ?></td>
				</tr>
			<?php  
				foreach($aclLinks as $aclLink)
				{ 
					if($controller == $aclLink['AclLink']['controller'])
					{?>
					<tr class="hide <?php echo $aclLink['AclLink']['controller'];?>"> 
					<td class="acl-name"><?php echo $aclLink['AclLink']['name']; ?></td>
					<?php 
					for($i=0;$i<$roles_count;$i++)
					{ ?>
					<td>
						<ul class="permission-links">
							<li><?php echo $this->Html->link(__l('None'), array('action' => 'toggle',$aclLink['AclLink']['id'],$roles[$i]['Role']['id'],ConstAclStatuses::None), array('title' => __l('None'), 'class' => 'no-permission js-ajax-link')); ?>
							</li>
							<li><?php echo $this->Html->link(__l('Owner'), array('action' => 'toggle',$aclLink['AclLink']['id'],$roles[$i]['Role']['id'],ConstAclStatuses::Owner), array('title' => __l('Owner'), 'class' => 'individual-permission js-ajax-link')); ?>
							</li>
							<li><?php echo $this->Html->link(__l('Group'), array('action' => 'toggle',$aclLink['AclLink']['id'],$roles[$i]['Role']['id'],ConstAclStatuses::Group), array('title' => __l('Group'), 'class' => 'group-permission js-ajax-link')); ?>
							</li>
							<li><?php echo $this->Html->link(__l('All'), array('action' => 'toggle',$aclLink['AclLink']['id'],$roles[$i]['Role']['id'],ConstAclStatuses::All), array('title' => __l('All'), 'class' => 'all-permission js-ajax-link')); ?>
							</li>
						</ul>
					</td>
					<?php } ?>
					</tr>
				<? }
					} ?>
				<?php 
			}
		endif;
	?>
	</table>
</div>