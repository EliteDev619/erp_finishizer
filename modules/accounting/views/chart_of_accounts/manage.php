<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="panel_s">
        <div class="panel-body">
          <h2 class="m-0 font-bold text-lg">
            <?php echo _l($title); ?>
          </h2>
          <div class='mb-3 mt-3'>
            <a href="#" class="btn btn-info add-new-account">
              <?php echo _l('Add'); ?>
            </a>
            <a href="#" class="btn btn-info edit-account">
              <?php echo _l('Edit'); ?>
            </a>
            <a href="#" class="btn btn-info delete-account pull-right">
              <?php echo _l('Delete'); ?>
            </a>
          </div>

          <div class="grid gap-6 md:grid-cols-2">
            <div class="p-2 shadow-lg ">
              <form>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                  </div>
                  <input type="search" id="default-search"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search..." required>
                  <button type="submit"
                    class="account_type_search text-white absolute right-2 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
              </form>

              <div class="account_treeview mt-5 p-5 rounded border-solid border border-gray-300 text-lg">
              </div>
            </div>

            <div class='p-5 shadow-lg pt-5 '>
              <div class="">
                <div class="form-group">
                  <h4 class="text-lg  text-gray-500">Account Type</h4>
                  <div class="flex ">
                    <div class="flex items-center mr-8">
                      <input id="account_type_main" type="radio" value="main" name="report_account_type"
                        class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300" disabled>
                      <label for="account_type_main"
                        class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Main</label>
                    </div>
                    <div class="flex items-center mr-8">
                      <input id="account_type_sub" type="radio" value="sub" name="report_account_type"
                        class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300" disabled>
                      <label for="account_type_sub"
                        class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Sub</label>
                    </div>
                  </div>
                </div>
                <div class="form-group parent_account hide">
                  <label for="parent_account" class="control-label">Parent Account</label>
                  <input type='text' id='parent_account' name='report_parent_account' class='pl-5 h-10 w-full'
                    readonly />
                </div>
                <div class="form-group row m-0 mb-5">
                  <div class="col-md-3 p-0">
                    <input type='text' name='report_account_no' placeholder="Account No" class='h-10 pl-5 w-full'
                      readonly />
                  </div>
                  <div class="col-md-9">
                    <input type='text' name='report_account_name' placeholder="Account Name" class='pl-5 h-10 w-full'
                      readonly />
                  </div>
                </div>
                <div class="report_sub_items hide">
                  <div class="form-group">
                    <label for="account_cost_center" class="control-label">Cost Center</label>
                    <input type='text' id='account_cost_center' name='report_account_cost_center'
                      class='pl-5 h-10 w-full' readonly />
                  </div>
                  <div class="form-group">
                    <label for="account_currency" class="control-label">Currency</label>
                    <input type='text' id='account_currency' name='report_account_currency' class='pl-5 h-10 w-full'
                      readonly />
                  </div>
                  <div class="form-group">
                    <label for="account_category" class="control-label">Category</label>
                    <input type='text' id='account_category' name='report_account_category' class='pl-5 h-10 w-full'
                      readonly />
                  </div>
                  <div class="form-group">
                    <div class="flex ">
                      <div class="flex items-center mr-8">
                        <input id="sub_account_stop" type="radio" value="sub_acc_stop" name="sub_account_status"
                          class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300" disabled>
                        <label for="sub_account_stop"
                          class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Stop
                          Account</label>
                      </div>
                      <div class="flex items-center mr-8">
                        <input id="sub_account_special" type="radio" value="sub_acc_special" name="sub_account_status"
                          class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300" disabled>
                        <label for="sub_account_special"
                          class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Special Account</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $arrAtt = array();
$arrAtt['data-type'] = 'currency';
?>


<div class="modal fade" id="account-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title font-bold text-lg"></h2>
      </div>
      <?php echo form_open_multipart(admin_url('accounting/account'), array('id' => 'account-form')); ?>
      <?php echo form_hidden('id'); ?>
      <div class="modal-body">
        <div class="form-group">
          <h4 class="text-lg ml-10 text-gray-500">Account Type</h4>
          <div class="flex ml-10">
            <div class="flex items-center mr-8">
              <input id="account_type_main" type="radio" checked value="main" name="account_type"
                class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="account_type_main"
                class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Main</label>
            </div>
            <div class="flex items-center mr-8">
              <input id="account_type_sub" type="radio" value="sub" name="account_type"
                class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="account_type_sub"
                class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Sub</label>
            </div>
          </div>
        </div>
        <div class="form-group modal_parent_account hide ml-10">
          <h4 class="text-lg text-gray-500">Parent Account</h4>
          <input type='text' name='parent_account_id' class='hide' value='' />
          <input type='text' name='parent_account_text' class='h-10 pl-5 w-full mt-2' value='' readonly />
          <div class="account_treeview mt-5 p-5 rounded border-solid border border-gray-300 text-lg">
          </div>
        </div>
        <div class="form-group row ml-10">
          <div class="col-md-3 p-0">
            <input type='text' name='account_no' class='h-10 pl-5 w-full' value='' placeholder='Account No' readonly />
          </div>
          <div class="col-md-9">
            <input type='text' name='account_name' class='pl-5 h-10 w-full' placeholder='Account Name' />
          </div>
        </div>
        <div class='modal_sub_items hide'>
          <div class="form-group">
            <div class='ml-10'>
              <?php echo render_select('account_cost_center', $account_cost_center, array('name', 'name'), 'Cost Center', '', array(), array(), '', '', false); ?>
            </div>
          </div>
          <div class="form-group">
            <div class='ml-10'>
              <?php echo render_select('account_currency', $account_currency, array('id', 'name'), 'Currency', '', array(), array(), '', '', false); ?>
            </div>
          </div>
          <div class="form-group">
            <div class='ml-10'>
              <?php echo render_select('account_category', $account_category, array('name', 'name'), 'Category', '', array(), array(), '', '', false); ?>
            </div>
          </div>
          <div class="form-group">
            <div class="flex ml-10">
              <div class="flex items-center mr-8">
                <input id="sub_account_stop" type="radio" value="sub_acc_stop" name="sub_account_status"
                  class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="sub_account_stop" class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Stop
                  Account</label>
              </div>
              <div class="flex items-center mr-8">
                <input id="sub_account_special" type="radio" value="sub_acc_special" name="sub_account_status"
                  class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="sub_account_special"
                  class="text-lg ml-3 mt-2 font-lg text-gray-900 dark:text-gray-300">Special Account</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <?php echo _l('close'); ?>
        </button>
        <button type="submit" class="btn btn-info btn-submit">
          <?php echo _l('submit'); ?>
        </button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<!-- <div class="modal fade" id="account-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo _l('acc_account') ?></h4>
      </div>
      <?php echo form_open_multipart(admin_url('accounting/account'), array('id' => 'account-form')); ?>
      <?php echo form_hidden('id'); ?>
      <?php echo form_hidden('update_balance'); ?>
      <div class="modal-body">
          <?php echo render_select('account_type_id', $account_types, array('id', 'name'), 'account_type', '', array(), array(), '', '', false); ?>
          <?php echo render_select('account_detail_type_id', $detail_types, array('id', 'name'), 'detail_type', '', array(), array(), '', '', false); ?>
          <p><i class="detail_type_note"><?php echo html_entity_decode($detail_types[0]['note']); ?></i></p>
        <?php echo render_input('name', 'name'); ?>
        <?php if (get_option('acc_enable_account_numbers') == 1) {
          echo render_input('number', 'number');
        } ?>
        <?php echo render_select('parent_account', $accounts, array('id', 'name'), 'parent_account'); ?>
        <div class="row hide" id="div_balance">
          <div class="col-md-6">
          <?php echo render_input('balance', 'balance', '', 'text', $arrAtt); ?>
          </div>
          <div class="col-md-6">
          <?php echo render_date_input('balance_as_of', 'as_of'); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p class="bold"><?php echo _l('dt_expense_description'); ?></p>
            <?php echo render_textarea('description', '', '', array(), array(), '', 'tinymce'); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="submit" class="btn  bg-yellow-400 btn-submit"><?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div> -->


<!-- <div class="modal fade bulk_actions" id="accounts_bulk_actions" tabindex="-1" role="dialog" data-table=".table-accounts">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
         </div>
         <div class="modal-body">
            <?php if (has_permission('accounting_chart_of_accounts', '', 'edit')) { ?>
               <div class="checkbox checkbox-info">
                  <input type="checkbox" name="mass_activate" id="mass_activate">
                  <label for="mass_activate"><?php echo _l('mass_activate'); ?></label>
               </div>
            <?php } ?>
            <?php if (has_permission('accounting_chart_of_accounts', '', 'edit')) { ?>
               <div class="checkbox checkbox-info">
                  <input type="checkbox" name="mass_deactivate" id="mass_deactivate">
                  <label for="mass_deactivate"><?php echo _l('mass_deactivate'); ?></label>
               </div>
            <?php } ?>
            <?php if (has_permission('accounting_chart_of_accounts', '', 'detele')) { ?>
               <div class="checkbox checkbox-danger">
                  <input type="checkbox" name="mass_delete" id="mass_delete">
                  <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
               </div>
            <?php } ?>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
         <a href="#" class="btn btn-info" onclick="bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
      </div>
   </div>
   <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div> -->
<!-- /.modal -->
<?php init_tail(); ?>

</body>

</html>
<?php require 'modules/accounting/assets/js/chart_of_accounts/manage_js.php'; ?>