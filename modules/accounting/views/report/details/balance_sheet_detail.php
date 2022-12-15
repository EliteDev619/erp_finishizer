<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('balance_sheet_detail'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
          <th><?php echo _l('transaction_type'); ?></th>
          <th><?php echo _l('description'); ?></th>
          <th class="total_amount"><?php echo _l('debit'); ?></th>
          <th class="total_amount"><?php echo _l('credit'); ?></th>
          <th class="total_amount"><?php echo _l('acc_amount'); ?></th>
          <th class="total_amount"><?php echo _l('balance'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="treegrid-100000 parent-node expanded">
          <td class="parent"><?php echo _l('acc_assets'); ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php
         $row_index = 0;
         $parent_index = 100000;
         $total_assets = 0;
          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['accounts_receivable'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_assets += $data['total_amount'];

          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['cash_and_cash_equivalents'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
          $total_assets += $data['total_amount'];

          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
          $total_assets += $data['total_amount'];

          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['fixed_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
          $total_assets += $data['total_amount'];

          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['non_current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
          $total_assets += $data['total_amount'];

          ?>
        <?php $row_index += 1; ?>
          <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_assets'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total_assets, $currency->name); ?> </td>
            <td></td>
          </tr>
        <tr class="treegrid-100001 parent-node expanded">
          <td class="parent"><?php echo _l('liabilities_and_shareholders_equity'); ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php $row_index += 1;
          $_parent_index = $row_index; 
          ?>
        <tr class="treegrid-<?php echo html_entity_decode($_parent_index); ?> treegrid-parent-100001 parent-node expanded">
          <td class="parent"><?php echo _l('liabilities'); ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php 
        $total_liabilities = 0;
          $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['accounts_payable'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $_parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_liabilities += $data['total_amount'];

         $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['credit_card'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $_parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_liabilities += $data['total_amount'];

         $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $_parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_liabilities += $data['total_amount'];

         $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['non_current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $_parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_liabilities += $data['total_amount'];

         $row_index += 1;
         ?>
         <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-100001 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('liabilities')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total_liabilities, $currency->name); ?> </td>
            <td></td>
          </tr>
         <?php
         $row_index += 1;
          $_parent_index = $row_index ; 
          $total_equity = 0;
         ?>
         <tr class="treegrid-<?php echo html_entity_decode($_parent_index); ?> treegrid-parent-100001 parent-node expanded">
          <td class="parent"><?php echo _l('equity'); ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
         <?php 
         $data = $this->accounting_model->get_html_balance_sheet_detail($data_report['data']['owner_equity'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0], $_parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         $total_equity += $data['total_amount'];
         $total_equity += $data_report['net_income'];
         $row_index += 1;

        ?>
        <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($_parent_index); ?> parent-node expanded tr_total">
            <td class="parent"><?php echo _l('acc_net_income'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($data_report['net_income'], $currency->name); ?> </td>
            <td></td>
          </tr>
          <?php $row_index += 1; ?>
        
        <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-100001 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_for', _l('equity')); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total_equity, $currency->name); ?> </td>
            <td></td>
          </tr>
          <?php $row_index += 1; 
          $total_liabilities_and_equity = $total_equity + $total_liabilities;
        ?>
          <?php $row_index += 1; ?>
          <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-100011 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_liabilities_and_equity'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total_amount"><?php echo app_format_money($total_liabilities_and_equity, $currency->name); ?> </td>
            <td></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>