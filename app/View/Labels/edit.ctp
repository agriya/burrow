<?php /* SVN: $Id: $ */ ?>
<div class="mail-right-block ">
	<div class="block2-tl">
    	<div class="block2-tr">
    		<div class="block2-tm">
                    <h4><?php echo __l('Mail');?></h4>
            </div>
         </div>
	</div>
	<div class="block1-cl">
		<div class="block1-cr">
			<div class="block1-cm">
				<div class="main-section main-message-block">
					<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="block2-bl">
		<div class="block2-br">
			<div class="block2-bm">
			</div>
		</div>
	</div>
</div>

<div class="messages message-side2 ">
	<div class="block2-tl">
		<div class="block2-tr">
			<div class="block2-tm">
                <h2 class="title"><?php echo __l('Edit Label'); ?></h2>
			</div>
		</div>
	</div>
	<div class="block1-cl">
		<div class="block1-cr">
			<div class="block1-cm">
				<div class="main-section">
					<div class="labels form">
						<div class="form-blocks js-corner round-5">
							<div class="labels form">
								<?php echo $this->Form->create('Label', array('class' => 'normal clearfix'));?>
									<fieldset>
									<?php
										echo $this->Form->input('id');
										echo $this->Form->input('name');
									?>
									</fieldset>
								<?php echo $this->Form->end(__l('Update'));?>
							</div>
						 </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block2-bl">
		<div class="block2-br">
			<div class="block2-bm">
			</div>
		</div>
	</div>
</div>


