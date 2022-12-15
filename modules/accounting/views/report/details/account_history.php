<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('account_history'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('split'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <?php if($data_report['account_type'] == 3){ ?>
            <th class="total_amount"><?php echo _l('payment'); ?></th>
            <th class="total_amount"><?php echo _l('deposit'); ?></th>
          <?php }elseif($data_report['account_type'] == 7 || $data_report['account_type'] == 1){ ?>
            <th class="total_amount"><?php echo _l('charge'); ?></th>
            <th class="total_amount"><?php echo _l('payment'); ?></th>
          <?php }else{ ?>
            <th class="total_amount"><?php echo _l('decrease'); ?></th>
            <th class="total_amount"><?php echo _l('increase'); ?></th>
          <?php } ?>
          <th class="total_amount"><?php echo _l('balance'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 0; 
         ?>

         <?php foreach ($data_report['data'] as $val) { 
              $row_index += 1;
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
              <td>
              <?php echo _d($val['date']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['type']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['split']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['description']); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['decrease'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['increase'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['balance'], $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
      </tbody>
    </table>
  </div>
</div>