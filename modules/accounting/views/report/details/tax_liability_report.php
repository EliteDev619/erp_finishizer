<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('journal'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th></th>
          <th class="total_amount"><?php echo _l('amount'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 0; 
         $parent_index = 0; 
         $total = 0; 
         ?>

         <?php foreach ($data_report['data'] as $val) { 
              $row_index += 1;
              $total += $val['amount'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
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
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> expanded tr_total treegrid-parent-10000">
            <td class="parent"><?php echo _l('total'); ?></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?> </td>
          </tr>
      </tbody>
    </table>
  </div>
</div>