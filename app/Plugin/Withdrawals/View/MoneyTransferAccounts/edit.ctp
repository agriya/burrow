<div class="moneyTransferAccounts form js-responses">
  <div class="main-content-block js-corner disk-usage round-5">
     <div id='my-profile'>
      <div class="form-blocks  js-corner round-5">
        <?php echo $this->Form->create('MoneyTransferAccount', array('action' => 'edit', 'class' => 'normal add-live-form js-ajax-form'));?>
          <fieldset  class="form-block">
            <h3><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['display_name']); ?></h3>
            <?php
               echo '<div class="ver-space">';
              echo $this->Form->input('payment_gateway_id',array('type' => 'hidden'));
              echo '</div>';
              echo $this->Form->input('account',array('label' => __l('Account')));
            ?>
          </fieldset>
          <div class="form-actions">
          <?php
            echo $this->Form->submit(__l('Update'));
          ?>
          </div>
        <?php
          echo $this->Form->end();
        ?>

      </div>
    </div>
  </div>
</div>