<?php /* SVN: $Id: $ */ ?>
<div class="userOpenids index js-response">
   	<div><?php echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add')));?></div>
    <?php echo $this->Form->create('UserOpenid' , array('method' => 'get', 'class' => 'normal','action' => 'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $this->Form->input('q', array('label' => 'Keyword')); ?>
		</div>
		<div>
			<?php echo $this->Form->submit(__l('Search'));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
    <?php echo $this->Form->create('UserOpenid' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th class="select span2"><?php echo __l('Select'); ?></th>
            <th class="actions span2"><?php echo __l('Actions');?></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Username'));?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort('openid');?></div></th>
        </tr>
        <?php
        if (!empty($userOpenids)):
            $i = 0;
            foreach ($userOpenids as $userOpenid):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td><?php echo $this->Form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => '', 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
                    <td class="actions"><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
                    <td><?php echo $this->Html->link($this->Html->cText($userOpenid['User']['username']), array('controller'=> 'users', 'action'=>'view', $userOpenid['User']['username'], 'admin' => false), array('escape' => false));?></td>
                    <td><?php echo $this->Html->cText($userOpenid['UserOpenid']['openid']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No User Openids available');?></p></div></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    <?php
    if (!empty($userOpenids)) :
        ?>
        <div class="clearfix">
       <div class="admin-select-block clearfix ">
            <?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
        </div>
        <div class="js-pagination ">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <div class=hide>
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>