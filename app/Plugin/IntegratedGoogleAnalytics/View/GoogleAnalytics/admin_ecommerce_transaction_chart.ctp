<div class="span24 offset2">
<div class="row-fluid ver-space">
	  <?php if ($transaction_percentage > 0) {
              $transaction_color = '#459D1C';
            } elseif ($transaction_percentage == 0) {
              $transaction_color = '#757575';
            } elseif ($transaction_percentage < 0) {
              $transaction_color = '#BA1E20';
            }
            if ($transactionRevenue_percentage > 0) {
              $transactionRevenue_color = '#459D1C';
            } elseif ($transactionRevenue_percentage == 0) {
              $transactionRevenue_color = '#757575';
            } elseif ($transactionRevenue_percentage < 0) {
              $transactionRevenue_color = '#BA1E20';
            }
		?>
			 <div class="span7 dc space no-mar pr">
                <div class="btn dc show span8">
                  <div style="display: none; visbility:hidden;""><div class="js-line-chart {'colour':'<?php echo $transaction_color; ?>'}"><?php echo $transaction; ?></div></div>
                  <div class="textb" style="color:<?php echo $transaction_color; ?>"><?php echo $transaction_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_transaction; ?></h2>
                  <h5><?php echo __l('Transactions'); ?></h5>
                </div>
              </div>
              <div class="span7 dc space no-mar pr">
                <div class="btn dc show span8">
                  <div style="display: none; visbility:hidden;""><div class="js-line-chart {'colour':'<?php echo $transactionRevenue_color; ?>'}"><?php echo $transactionRevenue; ?></div></div>
                  <div class="textb" style="color:<?php echo $transactionRevenue_color; ?>"><?php echo $transactionRevenue_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_transactionRevenue .' ('.Configure::read('site.currency').')'; ?></h2>
                  <h5><?php echo __l('Transaction Revenue'); ?></h5>
                </div>
              </div>
			   <span class="alert alert-info span8 dl"> <?php echo __l('Transactions is the total number of completed purchases on your site. The total revenue from ecommerce transactions. Depending on your implementation, this can include tax and shipping.');?></span>
        </div>
		</div>