<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('recent_transactions'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('customer'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <th><?php echo _l('acc_account'); ?></th>
          <th class="th_total"><?php echo _l('acc_amount'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 1; 
         $parent_index = 1; 
         $total_amount = 0; 
         ?>

          <?php foreach ($data_report['data'] as $key => $value) { ?>
            <?php
         $row_index += 1; 
         $parent_index = $row_index; 
         $total_amount = 0; 
         ?>
          <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> parent-node expanded">
            <td class="parent"><?php echo _l($key); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         <?php foreach ($value as $val) { ?>
              <?php 
              $row_index += 1;
              $total_amount += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> ">
              <td>
              <?php echo _d($val['date']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['type']); ?> 
              </td>
              <td>
              <?php echo get_company_name($val['customer']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['description']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['name']); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l($key)); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total_amount, $currency->name); ?> </td>
          </tr>
          <?php } ?> 
          
      </tbody>
    </table>
  </div>
</div>