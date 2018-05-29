<?php 
$this->loadHelper('Calendar');
if(!empty($type) && $type == 'guest'):?>
	<div class="js-calendar-response js-guestcalender-load-block">
		<?php
			echo $this->Calendar->month($year, $month, $data);
		?>
	</div>
<?php else: ?>
	<div class="calendarBody js-calander-load {'id':'<?php echo $id; ?>'}">

      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead">
			<h3 class="well space textb text-16"><?php echo __l('My Calendar');?></h3>
                <div  id="js-edit-month" class="fbutton">
	                <div class="price-button">
                    	<input type="button" id="js-edit-month-price" value="Edit Monthly Price"/> 
                    </div>
                    <div id="js-edit-month-price-content" class="js-edit-month-price-bubble">
                    </div>
                </div>

                <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;"><?php echo __l('Loading data...');?></div>
                 <div id="errorpannel" class="ptogtitle loaderror" style="display: none;"><?php echo __l('Sorry, could not load your data, please try again later');?></div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
            <div class="btnseparator"></div>
                        <div id="showdaybtn" class="fbutton">
                <div><span title='<?php echo __l('Day'); ?>' class="showdayview"> <?php echo __l('Day'); ?></span></div>
            </div>
              <div  id="showweekbtn" class="fbutton">
                <div><span title='<?php echo __l('Week'); ?>' class="showweekview"> <?php echo __l('Week'); ?></span></div>
            </div>
            <div  id="showmonthbtn" class="fbutton fcurrent">
                <div><span title='<?php echo __l('Month'); ?>' class="showmonthview"> <?php echo __l('Month'); ?></span></div>
            </div>

              <div  id="showreflashbtn" class="fbutton">
                <div><span title="Refresh view" class="showdayflash"><?php echo __l('Refresh');?></span></div>
                </div>
             <div class="btnseparator"></div>
                <div id="sfprevbtn" title="Prev"  class="fbutton">
                  <span class="fprev"></span>

                </div>
                <div id="sfnextbtn" title="Next" class="fbutton">
                    <span class="fnext"></span>
                </div>
                <div class="fshowdatep fbutton">
                        <div>
                            <input type="hidden" name="txtshow" id="hdtxtshow" />
                            <span id="txtdatetimeshow"><?php echo __l('Loading');?></span>

                        </div>
                </div>

            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder clearfix">
        	<div id="gridcontainer1" class="<?php echo $clss=!empty($id)?'calendar':'fullcalendar'; ?>" style="overflow-y: visible;">
            </div>
            <div id="gridcontainer" class="<?php echo $clss=!empty($id)?'calendar':'fullcalendar'; ?>" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>
<?php endif;?>
