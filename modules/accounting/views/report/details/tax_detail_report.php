<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('tax_detail_report'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <th><?php echo _l('customer'); ?></th>
          <th><?php echo _l('tax_name'); ?></th>
          <th><?php echo _l('tax_rate'); ?></th>
          <th class="total_amount"><?php echo _l('amount'); ?></th>
          <th class="total_amount"><?php echo _l('balance'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 1; 
         $parent_index = 1; 
         $total = 0; 
         ?>
         <tr class="treegrid-10000 parent-node expanded">
            <td class="parent"><?php echo _l('tax_collected_on_sales'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         <?php foreach ($data_report['data']['tax_collected_on_sales'] as $val) {
              $row_index += 1;
              $total += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
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
              <?php echo get_company_name($val['customer']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['tax_name']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['tax_rate']); ?>%
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($total, $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('tax_collected_on_sales')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?></td>
            <td class="total_amount"></td>
          </tr>

          <?php
         $row_index++; 
         $total = 0; 
         ?>
         <tr class="treegrid-10001 parent-node expanded">
            <td class="parent"><?php echo _l('total_taxable_sales_in_period_before_tax'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         <?php foreach ($data_report['data']['total_taxable_sales_in_period_before_tax'] as $val) {
              $row_index += 1;
              $total += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10001 ">
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
              <?php echo get_company_name($val['customer']); ?> 
              </td>
              <td>
              
              </td>
              <td>
              
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($total, $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10001 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('total_taxable_sales_in_period_before_tax')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?></td>
            <td class="total_amount"></td>
          </tr>
          <?php $row_index += 1; 
           $total = 0; ?>
          <tr class="treegrid-10000 parent-node expanded">
            <td class="parent"><?php echo _l('tax_reclaimable_on_purchases'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         <?php foreach ($data_report['data']['tax_reclaimable_on_purchases'] as $val) {
              $row_index += 1;
              $total += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
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
              <?php echo get_company_name($val['customer']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['tax_name']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['tax_rate']); ?>%
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($total, $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('tax_reclaimable_on_purchases')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?></td>
            <td class="total_amount"></td>
          </tr>
          <?php $row_index += 1; 
           $total = 0; ?>
          <tr class="treegrid-10001 parent-node expanded">
            <td class="parent"><?php echo _l('total_taxable_purchases_in_period_before_tax'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
         <?php foreach ($data_report['data']['total_taxable_purchases_in_period_before_tax'] as $val) {
              $row_index += 1;
              $total += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10001 ">
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
              <?php echo get_company_name($val['customer']); ?> 
              </td>
              <td>
              
              </td>
              <td>
              
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['amount'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($total, $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10001 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('total_taxable_purchases_in_period_before_tax')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?></td>
            <td class="total_amount"></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>