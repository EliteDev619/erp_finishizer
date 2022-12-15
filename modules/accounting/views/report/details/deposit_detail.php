<div id="accordion">
    <div class="card">
      <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
      <h4 class="text-center"><?php echo _l('deposit_detail'); ?></h4>
      <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
      <table class="tree">
        <thead>
          <tr class="tr_header">
            <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
            <th><?php echo _l('transaction_type'); ?></th>
            <th><?php echo _l('customer'); ?></th>
            <th><?php echo _l('description'); ?></th>
            <th class="total_amount"><?php echo _l('acc_amount'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
           $row_index = 0;
           $parent_index = 0;

           $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['accounts_receivable'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['cash_and_cash_equivalents'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['fixed_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['non_current_assets'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['accounts_payable'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['credit_card'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['non_current_liabilities'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);

          $data = $this->accounting_model->get_html_deposit_detail($data_report['data']['owner_equity'], ['html' => '', 'row_index' => $row_index + 1, 'total_credit' => 0, 'total_debit' => 0], $parent_index, $currency);
          $row_index = $data['row_index'];
          echo html_entity_decode($data['html']);
         
          ?>
        </tbody>
      </table>
    </div>
</div>