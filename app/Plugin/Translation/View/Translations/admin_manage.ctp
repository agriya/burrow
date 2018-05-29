<?php /* SVN: $Id: admin_manage.ctp 71269 2011-11-14 10:50:18Z josephine_065at09 $ */ ?>
<div class="translations form">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link( 'Translation', array('action'=>'index'), array('escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Edit Translations </li>
            </ul> 
			  <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
 <div class="clearfix">
				<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Verified').'">'.__l('Verified').'</dt>
						<dd title="'.$this->Html->cInt($verified_count, false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($verified_count, false).'</dd>                  	
					</dl>'
					, array('action'=>'manage', 'language_id' => $this->request->data['Translation']['language_id'], 'filter' => 'verified'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Unverified').'">'.__l('Unverified').'</dt>
						<dd title="'.$this->Html->cInt($unverified_count, false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($unverified_count, false).'</dd>                  	
					</dl>'
					, array('action'=>'manage', 'language_id' => $this->request->data['Translation']['language_id'], 'filter' => 'unverified'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
	?>
	
<div class="">
    <?php /* Chart block */ ?>
    <?php
    $total = $verified_count + $unverified_count;
    $verified_percent =  round($verified_count*100/$total,3);
    $unverified_percent =  round($unverified_count*100/$total,3);
    $translate_verfified_percentage = $verified_percent.",".$unverified_percent;
    echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$translate_verfified_percentage.'&amp;chs=70x70&amp;chco=74B732|C1C1BA&amp;chf=bg,s,FF000000', array('title' => __l('Verified: ').$verified_percent.'%'));
    ?>
    <?php /* Chart block ends*/ ?>
</div>
</div>
<div class=" alert alert-info">
	<?php echo __l('If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.');?>
</div>
<?php echo $this->Form->create('Translation', array('action' => 'manage', 'class' => 'form-horizontal space')); ?>
	<fieldset>
	<div class="clearfix dl bot-space">
	<?php
		echo "<span class='hor-space'>".$this->Form->input('language_id',array('div'=>false))."</span>";
		echo $this->Form->input('filter', array('type' => 'hidden'));
		echo "<span class='hor-space'>".$this->Form->input('q', array('label' => false, 'placeholder' => 'Keyword', 'div'=>false))."</span>";
		?>
		<?php
		echo "<span class='hor-space'>".$this->Form->submit(__l('Submit'), array('div'=>false,'name' => 'data[Translation][makeSubmit]', 'class' => 'btn btn-large btn-primary textb text-16'))."</span>";
		?></div>
		<?php
		if(!empty($translations)):
			echo $this->element('paging_counter');
		endif;	     
		echo $this->Form->input('page', array('type' => 'hidden'));	
?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
<table class="table no-round ">
<thead>
  <tr class="well no-mar no-pad">
    <th class="graydarkc dc sep-right select"><?php echo __l('Verified'); ?></th>
    <th class="graydarkc dc sep-right"><?php echo __l('Original'); ?></th>
    <th class="graydarkc dc sep-right"><?php echo __l('Translated'); ?></th>
    <?php
		if(!empty($translations)):
			foreach ($translations as $translation):
			?>
    		<tr><td class=" dc select"> <?php echo $this->Form->input('Translation.'.$translation['Translation']['id'].'.is_verified', array('checked' => ($translation['Translation']['is_verified'])?true:false, 'class' => '', 'label' => "", 'div' => 'input checkbox no-mar')); ?></td>
            <td class="dc"> <?php echo $translation['Translation']['name']; ?></td>
             <td class="dc"> <?php echo $this->Form->input('Translation.'.$translation['Translation']['id'].'.lang_text', array('label' => false, 'value' => $translation['Translation']['lang_text'])); ?></td>
            </tr>
		<?php	
            endforeach;
			?>
	<tr><td colspan="3">
	       <div class="form-actions">
	            <?php 
				echo $this->Form->submit(__l('Update'), array('name' => 'data[Translation][makeUpdate]', 'class' => 'btn btn-large btn-primary textb text-16'));
			?>  
			</div>
        </td>
	</tr>
            

            <?php
		else:
	?>
	<tr><td colspan="3"><div class="space dc grayc"><p class="ver-mspace top-space text-16 ">
	<?php echo __l('No Translations available');?></p></div></td>
	</tr>
	<?php endif;?>
    </table>
	<div class="js-pagination pagination pull-right no-mar mob-clr dc">
	<?php  	if(!empty($translations)):
    			echo $this->element('paging_links');
			endif;
	?>
	</div>
	</div>
	</div>

	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>