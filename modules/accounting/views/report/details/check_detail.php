<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('cheque_detail'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('customer'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <th><?php echo _l('acc_amount'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $row_index = 1;
          $total = 0;
          ?>
          <?php 
        foreach ($data_report['data']['cash_and_cash_equivalents'] as $key => $value) {
          $row_index += 1;
          $parent_index = $row_index;
          $total_amount = 0;
          ?>
          <?php if(count($value['details']) > 0){ ?>

          <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> parent-node expanded">
            <td class="parent"><?php echo html_entity_decode($value['name']); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <?php foreach ($value['details'] as $val) { 
              $row_index += 1;
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?>">
              <td>
              <?php echo _d($val['datecreated']); ?> 
              </td>
              <td>
              <?php echo _l($val['rel_type']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode(get_company_name($val['customer'])); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['description']); ?> 
              </td>
              <td>
              <?php echo app_format_money($val['debit'] - $val['credit'], $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
        <?php } ?>
        <?php } ?>
        </tbody>
    </table>
  </div>
</div>