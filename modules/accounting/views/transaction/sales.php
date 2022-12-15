

<div class="horizontal-scrollable-tabs">
   <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
   <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
   <div class="horizontal-tabs">
      <ul class="nav nav-tabs profile-tabs row customer-profile-tabs nav-tabs-horizontal" role="tablist">
         <li role="presentation" class="<?php if($tab_2 == 'payment'){echo 'active';}; ?>">
            <a href="<?php echo admin_url('accounting/transaction?group=sales&tab=payment'); ?>">
              <i class="fa fa-credit-card"></i>&nbsp;<?php echo _l('payment'); ?> <span class="text-danger"><?php echo '('.$count_payment.')'; ?></span>
            </a>
         </li>
         <li role="presentation" class="<?php if($tab_2 == 'invoice'){echo 'active';}; ?>">
            <a href="<?php echo admin_url('accounting/transaction?group=sales&tab=invoice'); ?>">
              <i class="fa fa-file-text"></i>&nbsp;<?php echo _l('invoice'); ?> <span class="text-danger"><?php echo '('.$count_invoice.')'; ?></span>
            </a>
         </li>
      </ul>
   </div>
    <?php echo form_hidden('currency_id', $currency->id); ?>
  <?php $this->load->view($tab_2,array('bulk_actions'=>true)); ?>
</div>
