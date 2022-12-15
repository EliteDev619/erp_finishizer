<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('balance_sheet_comparison'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th rowspan="2"></th>
          <th colspan="2" class="text-center th_total"><?php echo _l('total'); ?></th>
        </tr>
        <tr class="tr_header">
          <th class="th_total"><?php echo html_entity_decode($data_report['this_year']); ?></th>
          <th class="th_total"><?php echo html_entity_decode($data_report['last_year']); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="treegrid-1000 parent-node expanded">
          <td class="parent"><?php echo _l('acc_assets'); ?></td>
          <td></td>
        </tr>
        <?php
          $row_index = 0;
          $parent_index = 0;
          $row_index += 1;
          $parent_index = $row_index;
          $total_current_assets = 0;
          $total_py_current_assets = 0;
          ?>
          <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> treegrid-parent-1000 parent-node expanded">
            <td class="parent"><?php echo _l('acc_current_assets'); ?></td>
            <td></td>
            <td></td>
          </tr>
          <?php
          $row_index += 1;
          ?>
          <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> parent-node expanded">
            <td class="parent"><?php echo _l('acc_accounts_receivable'); ?></td>
            <td></td>
            <td></td>
          </tr>
           <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['accounts_receivable'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $row_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_assets += $data['total_amount'];
            $total_py_current_assets += $data['total_py_amount'];
            ?>
          <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_accounts_receivable'); ?></td>
            <td class="total_amount"><?php echo app_format_money($data['total_amount'], $currency->name); ?> </td>
            <td class="total_amount"><?php echo app_format_money($data['total_py_amount'], $currency->name); ?> </td>
          </tr>
          <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['cash_and_cash_equivalents'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_assets += $data['total_amount'];
            $total_py_current_assets += $data['total_py_amount'];
            ?>
          <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_assets += $data['total_amount'];
            $total_py_current_assets += $data['total_py_amount'];
            ?>
          
          <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-1000 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_current_assets'); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_current_assets, $currency->name); ?> </td>
            <td class="total_amount"><?php echo app_format_money($total_py_current_assets, $currency->name); ?> </td>
          </tr>
          <?php 
            $row_index += 1;
            $parent_index = $row_index;
            $total_long_term_assets = 0;
            $total_py_long_term_assets = 0;
          ?>
          <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> treegrid-parent-1000 parent-node expanded">
            <td class="parent"><?php echo _l('long_term_assets'); ?></td>
            <td></td>
          </tr>
          <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['fixed_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_long_term_assets += $data['total_amount'];
            $total_py_long_term_assets += $data['total_py_amount'];
            ?>
          <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['non_current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_long_term_assets += $data['total_amount'];
            $total_py_long_term_assets += $data['total_py_amount'];
            ?>
          <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-1000 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total_long_term_assets'); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_long_term_assets, $currency->name); ?> </td>
            <td class="total_amount"><?php echo app_format_money($total_py_long_term_assets, $currency->name); ?> </td>
          </tr>
          <?php 
            $row_index += 1;
            ?>
          <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> tr_total">
            <td class="parent"><?php echo _l('total_assets'); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_current_assets + $total_long_term_assets, $currency->name); ?> </td>
            <td class="total_amount"><?php echo app_format_money($total_py_current_assets + $total_py_long_term_assets, $currency->name); ?> </td>
          </tr>
          <?php 
            $row_index += 1;
            ?>
            <tr class="treegrid-1001 parent-node expanded">
              <td class="parent"><?php echo _l('liabilities_and_shareholders_equity'); ?></td>
              <td></td>
            </tr>
            <?php
            $row_index += 1;
            $parent_index = $row_index;
            $total_current_liabilities = 0;
            $total_py_current_liabilities = 0;
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> treegrid-parent-1001 parent-node expanded">
              <td class="parent"><?php echo _l('acc_current_liabilities'); ?></td>
              <td></td>
            </tr>
            <?php $row_index += 1; ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> parent-node expanded">
              <td class="parent"><?php echo _l('accounts_payable'); ?></td>
              <td></td>
            </tr>
            <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['accounts_payable'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $row_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_liabilities += $data['total_amount'];
            $total_py_current_liabilities += $data['total_py_amount'];
            ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?> tr_total">
              <td class="parent"><?php echo _l('total_accounts_payable'); ?></td>
              <td class="total_amount"><?php echo app_format_money($data_report['total']['accounts_payable']['this_year'], $currency->name); ?> </td>
              <td class="total_amount"><?php echo app_format_money($data_report['total']['accounts_payable']['last_year'], $currency->name); ?> </td>
            </tr>
            <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['credit_card'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_liabilities += $data['total_amount'];
            $total_py_current_liabilities += $data['total_py_amount'];
            ?>
            <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_current_liabilities += $data['total_amount'];
            $total_py_current_liabilities += $data['total_py_amount'];
            ?>
            <?php  $row_index += 1; ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-1001 tr_total">
              <td class="parent"><?php echo _l('total_current_liabilities'); ?></td>
              <td class="total_amount"><?php echo app_format_money($total_current_liabilities, $currency->name); ?> </td>
              <td class="total_amount"><?php echo app_format_money($total_py_current_liabilities, $currency->name); ?> </td>
            </tr>
            <?php $row_index += 1; ?>
            <?php
            $row_index += 1;
            $parent_index = $row_index;
            $total_non_current_liabilities = 0;
            $total_py_non_current_liabilities = 0;
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> treegrid-parent-1001 parent-node expanded">
              <td class="parent"><?php echo _l('acc_non_current_liabilities'); ?></td>
              <td></td>
            </tr>
            <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['non_current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_non_current_liabilities += $data['total_amount'];
            $total_py_non_current_liabilities += $data['total_py_amount'];
            ?>
            <?php $row_index += 1; ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-1001 tr_total">
              <td class="parent"><?php echo _l('total_non_current_liabilities'); ?></td>
              <td class="total_amount"><?php echo app_format_money($total_non_current_liabilities, $currency->name); ?> </td>
              <td class="total_amount"><?php echo app_format_money($total_py_non_current_liabilities, $currency->name); ?> </td>
            </tr>

            <?php $row_index += 1; ?>
            <?php
            $row_index += 1;
            $parent_index = $row_index;
            $total_shareholders_equity = $data_report['this_net_income'];
            $total_py_shareholders_equity = $data_report['last_net_income'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($parent_index); ?> treegrid-parent-1001 parent-node expanded">
              <td class="parent"><?php echo _l('shareholders_equity'); ?></td>
              <td></td>
            </tr>
            <?php $row_index += 1; ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-<?php echo html_entity_decode($parent_index); ?>">
              <td >
                <?php echo _l('acc_net_income'); ?> 
              </td>
              <td class="total_amount">
                <?php echo app_format_money($data_report['this_net_income'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($data_report['last_net_income'], $currency->name); ?> 
              </td>
            </tr>
            <?php 
            $data = $this->accounting_model->get_html_balance_sheet_comparision($data_report['data']['owner_equity'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], $parent_index, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total_shareholders_equity += $data['total_amount'];
            $total_py_shareholders_equity += $data['total_py_amount'];
            ?>
            <?php $row_index += 1; ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-1001 tr_total">
              <td class="parent"><?php echo _l('total_shareholders_equity'); ?></td>
              <td class="total_amount"><?php echo app_format_money($total_shareholders_equity, $currency->name); ?> </td>
              <td class="total_amount"><?php echo app_format_money($total_py_shareholders_equity, $currency->name); ?> </td>
            </tr>
            <?php $row_index += 1; ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> tr_total">
              <td class="parent"><?php echo _l('total_liabilities_and_equity'); ?></td>
              <td class="total_amount"><?php echo app_format_money($total_current_liabilities + $total_non_current_liabilities + $total_shareholders_equity, $currency->name); ?> </td>
              <td class="total_amount"><?php echo app_format_money($total_py_current_liabilities + $total_py_non_current_liabilities + $total_py_shareholders_equity, $currency->name); ?> </td>
            </tr>
            <?php $row_index += 1; ?>
        </tbody>
    </table>
  </div>
</div>