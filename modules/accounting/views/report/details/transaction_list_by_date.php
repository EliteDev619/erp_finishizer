<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('transaction_list_by_date'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <th><?php echo _l('acc_account'); ?></th>
          <th><?php echo _l('split'); ?></th>
          <th class="total_amount"><?php echo _l('acc_amount'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 0; 
         $parent_index = 0; 
         $total_debit = 0; 
         $total_credit = 0; 
         ?>

         <?php foreach ($data_report['data'] as $val) { 
              $row_index += 1;
              $total_debit += $val['debit'];
              $total_credit += $val['credit'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000">
              <td>
              <?php echo _d($val['date']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['type']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['description']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['name']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['split']); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
      </tbody>
    </table>
  </div>
</div>