<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('statement_of_changes_in_equity'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th></th>
          <th class="th_total"><?php echo _l('total'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $row_index = 1;
          $data = $this->accounting_model->get_html_statement_of_changes_in_equity($data_report['data']['owner_equity'], ['html' => '', 'row_index' => $row_index + 1, 'total_amount' => 0, 'total_py_amount' => 0], 0, $currency);
            $row_index = $data['row_index'];
            echo html_entity_decode($data['html']);
            $total = $data['total_amount'];
          ?>
            <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> parent-node expanded tr_total treegrid-parent-10000">
              <td class="parent"><?php echo _l('total_equity'); ?></td>
              <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?> </td>
            </tr>
        </tbody>
    </table>
  </div>
</div>