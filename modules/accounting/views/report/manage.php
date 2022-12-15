<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="panel_s">
        <div class="panel-body">
          <h4 class="no-margin font-bold"><?php echo _l($title); ?></h4>
          <hr />
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse1"><?php echo _l('business_overview'); ?></a>
                </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      
                    <div class="col-md-6">
                      <a href="<?php echo admin_url('accounting/rp_balance_sheet_comparison'); ?>"><?php echo _l('balance_sheet_comparison'); ?></a>
                      <p><?php echo _l('balance_sheet_comparison_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_balance_sheet_detail'); ?>"><?php echo _l('balance_sheet_detail'); ?></a>
                      <p><?php echo _l('balance_sheet_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_balance_sheet_summary'); ?>"><?php echo _l('balance_sheet_summary'); ?></a>
                      <p><?php echo _l('balance_sheet_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_balance_sheet'); ?>"><?php echo _l('balance_sheet'); ?></a>
                      <p><?php echo _l('balance_sheet_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_business_snapshot'); ?>" class="hide"><?php echo _l('business_snapshot'); ?></a>
                      <p class="hide"><?php echo _l('business_snapshot_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_custom_summary_report'); ?>"><?php echo _l('custom_summary_report'); ?></a>
                      <p><?php echo _l('custom_summary_report_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_as_of_total_income'); ?>"><?php echo _l('profit_and_loss_as_of_total_income'); ?></a>
                      <p><?php echo _l('profit_and_loss_as_of_total_income_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_comparison'); ?>"><?php echo _l('profit_and_loss_comparison'); ?></a>
                      <p><?php echo _l('profit_and_loss_comparison_note'); ?></p>
                      
                    </div>
                    <div class="col-md-6">
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_detail'); ?>"><?php echo _l('profit_and_loss_detail'); ?></a>
                      <p><?php echo _l('profit_and_loss_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_year_to_date_comparison'); ?>"><?php echo _l('profit_and_loss_year_to_date_comparison'); ?></a>
                      <p><?php echo _l('profit_and_loss_year_to_date_comparison_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_by_customer'); ?>" class="hide"><?php echo _l('profit_and_loss_by_customer'); ?></a>
                      <p class="hide"><?php echo _l('profit_and_loss_by_customer_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_by_month'); ?>" class="hide"><?php echo _l('profit_and_loss_by_month'); ?></a>
                      <p class="hide"><?php echo _l('profit_and_loss_by_month_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss'); ?>"><?php echo _l('profit_and_loss'); ?></a>
                      <p><?php echo _l('profit_and_loss_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_quarterly_profit_and_loss_summary'); ?>" class="hide"><?php echo _l('quarterly_profit_and_loss_summary'); ?></a>
                      <p class="hide"><?php echo _l('quarterly_profit_and_loss_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_statement_of_cash_flows'); ?>"><?php echo _l('statement_of_cash_flows'); ?></a>
                      <p><?php echo _l('statement_of_cash_flows_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_statement_of_changes_in_equity'); ?>"><?php echo _l('statement_of_changes_in_equity'); ?></a>
                      <p><?php echo _l('statement_of_changes_in_equity_note'); ?></p>
                    </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse5"><?php echo _l('bookkeeping'); ?></a>
                </h4>
              </div>
              <div id="collapse5" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                     <div class="col-md-6">
                        <a href="<?php echo admin_url('accounting/rp_account_list'); ?>"><?php echo _l('account_list'); ?></a>
                      <p><?php echo _l('account_list_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_balance_sheet_comparison'); ?>"><?php echo _l('balance_sheet_comparison'); ?></a>
                      <p><?php echo _l('balance_sheet_comparison_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_balance_sheet'); ?>"><?php echo _l('balance_sheet'); ?></a>
                      <p><?php echo _l('balance_sheet_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_exceptions_to_closing_date'); ?>"  class="hide"><?php echo _l('exceptions_to_closing_date'); ?></a>
                      <p class="hide"><?php echo _l('exceptions_to_closing_date_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_general_ledger'); ?>"><?php echo _l('general_ledger'); ?></a>
                      <p><?php echo _l('general_ledger_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_journal'); ?>"><?php echo _l('journal'); ?></a>
                      <p><?php echo _l('journal_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss_comparison'); ?>"><?php echo _l('profit_and_loss_comparison'); ?></a>
                      <p><?php echo _l('profit_and_loss_comparison_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_profit_and_loss'); ?>"><?php echo _l('profit_and_loss'); ?></a>
                      <p><?php echo _l('profit_and_loss_note'); ?></p>
                    </div>
                    <div class="col-md-6">
                      <a href="<?php echo admin_url('accounting/rp_account_history'); ?>"><?php echo _l('account_history'); ?></a>
                      <p><?php echo _l('account_history_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_recent_transactions'); ?>"><?php echo _l('recent_transactions'); ?></a>
                      <p><?php echo _l('recent_transactions_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_reconciliation_reports'); ?>" class="hide"><?php echo _l('reconciliation_reports'); ?></a>
                      <p class="hide"><?php echo _l('reconciliation_reports_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_recurring_template_list'); ?>" class="hide"><?php echo _l('recurring_template_list'); ?></a>
                      <p class="hide"><?php echo _l('recurring_template_list_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_statement_of_cash_flows'); ?>"><?php echo _l('statement_of_cash_flows'); ?></a>
                      <p><?php echo _l('statement_of_cash_flows_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_transaction_detail_by_account'); ?>"><?php echo _l('transaction_detail_by_account'); ?></a>
                      <p><?php echo _l('transaction_detail_by_account_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_transaction_list_by_date'); ?>"><?php echo _l('transaction_list_by_date'); ?></a>
                      <p><?php echo _l('transaction_list_by_date_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_transaction_list_with_splits'); ?>" class="hide"><?php echo _l('transaction_list_with_splits'); ?></a>
                      <p class="hide"><?php echo _l('transaction_list_with_splits_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_trial_balance'); ?>"><?php echo _l('trial_balance'); ?></a>
                      <p><?php echo _l('trial_balance_note'); ?></p>
                    </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse7"><?php echo _l('sales_tax'); ?></a>
                </h4>
              </div>
              <div id="collapse7" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-6">
                        <a href="<?php echo admin_url('accounting/rp_tax_detail_report'); ?>"><?php echo _l('tax_detail_report'); ?></a>
                        <p><?php echo _l('tax_detail_report_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_tax_exception_report'); ?>" class="hide"><?php echo _l('tax_exception_report'); ?></a>
                        <p class="hide"><?php echo _l('tax_exception_report_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_tax_summary_report'); ?>"><?php echo _l('tax_summary_report'); ?></a>
                        <p><?php echo _l('tax_summary_report_note'); ?></p>
                      </div>
                      <div class="col-md-6">
                        <a href="<?php echo admin_url('accounting/rp_tax_liability_report'); ?>"><?php echo _l('tax_liability_report'); ?></a>
                        <p><?php echo _l('tax_liability_report_note'); ?></p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse2"><?php echo _l('sales_and_customers'); ?></a>
                </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      
                    <div class="col-md-6">
                      <a href="<?php echo admin_url('accounting/rp_customer_contact_list'); ?>" class="hide"><?php echo _l('customer_contact_list'); ?></a>
                      <p class="hide"><?php echo _l('customer_contact_list_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_deposit_detail'); ?>"><?php echo _l('deposit_detail'); ?></a>
                      <p><?php echo _l('deposit_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_estimates_by_customer'); ?>" class="hide"><?php echo _l('estimates_by_customer'); ?></a>
                      <p class="hide"><?php echo _l('estimates_by_customer_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_income_by_customer_summary'); ?>"><?php echo _l('income_by_customer_summary'); ?></a>
                      <p><?php echo _l('income_by_customer_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_inventory_valuation_detail'); ?>" class="hide"><?php echo _l('inventory_valuation_detail'); ?></a>
                      <p class="hide"><?php echo _l('inventory_valuation_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_inventory_valuation_summary'); ?>" class="hide"><?php echo _l('inventory_valuation_summary'); ?></a>
                      <p class="hide"><?php echo _l('inventory_valuation_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_payment_method_list'); ?>" class="hide"><?php echo _l('payment_method_list'); ?></a>
                      <p class="hide"><?php echo _l('payment_method_list_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_product_service_list'); ?>" class="hide"><?php echo _l('product_service_list'); ?></a>
                      <p class="hide"><?php echo _l('product_service_list_note'); ?></p>
                    </div>
                    <div class="col-md-6">
                      <a href="<?php echo admin_url('accounting/rp_sales_by_customer_detail'); ?>" class="hide"><?php echo _l('sales_by_customer_detail'); ?></a>
                      <p class="hide"><?php echo _l('sales_by_customer_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_sales_by_customer_summary'); ?>" class="hide"><?php echo _l('sales_by_customer_summary'); ?></a>
                      <p class="hide"><?php echo _l('sales_by_customer_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_sales_by_product_service_detail'); ?>" class="hide"><?php echo _l('sales_by_product_service_detail'); ?></a>
                      <p class="hide"><?php echo _l('sales_by_product_service_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_sales_by_product_service_summary'); ?>" class="hide"><?php echo _l('sales_by_product_service_summary'); ?></a>
                      <p class="hide"><?php echo _l('sales_by_product_service_summary_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_stock_take_worksheet'); ?>" class="hide"><?php echo _l('stock_take_worksheet'); ?></a>
                      <p class="hide"><?php echo _l('stock_take_worksheet_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_time_activities_by_customer_detail'); ?>" class="hide"><?php echo _l('time_activities_by_customer_detail'); ?></a>
                      <p class="hide"><?php echo _l('time_activities_by_customer_detail_note'); ?></p>
                      <a href="<?php echo admin_url('accounting/rp_transaction_list_by_customer'); ?>" class="hide"><?php echo _l('transaction_list_by_customer'); ?></a>
                      <p class="hide"><?php echo _l('transaction_list_by_customer_note'); ?></p>
                    </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse3"><?php echo _l('expenses_and_suppliers'); ?></a>
                </h4>
              </div>
              <div id="collapse3" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-6">
                          <a href="<?php echo admin_url('accounting/rp_check_detail'); ?>"><?php echo _l('cheque_detail'); ?></a>
                        <p><?php echo _l('check_detail_note'); ?></p>
                          <a href="<?php echo admin_url('accounting/rp_expenses_by_supplier_summary'); ?>" class="hide"><?php echo _l('expenses_by_supplier_summary'); ?></a>
                        <p class="hide"><?php echo _l('expenses_by_supplier_summary_note'); ?></p>
                          <a href="<?php echo admin_url('accounting/rp_purchases_by_product_service_detail'); ?>" class="hide"><?php echo _l('purchases_by_product_service_detail'); ?></a>
                        <p class="hide"><?php echo _l('purchases_by_product_service_detail_note'); ?></p>
                      </div>
                      <div class="col-md-6">
                          <a href="<?php echo admin_url('accounting/rp_purchases_by_supplier_detail'); ?>" class="hide"><?php echo _l('purchases_by_supplier_detail'); ?></a>
                        <p class="hide"><?php echo _l('purchases_by_supplier_detail_note'); ?></p>
                          <a href="<?php echo admin_url('accounting/rp_supplier_contact_list'); ?>" class="hide"><?php echo _l('supplier_contact_list'); ?></a>
                        <p class="hide"><?php echo _l('supplier_contact_list_note'); ?></p>
                          <a href="<?php echo admin_url('accounting/rp_transaction_list_by_supplier'); ?>" class="hide"><?php echo _l('transaction_list_by_supplier'); ?></a>
                        <p class="hide"><?php echo _l('transaction_list_by_supplier_note'); ?></p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-group hide">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse4"><?php echo _l('employees'); ?></a>
                </h4>
              </div>
              <div id="collapse4" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                     <div class="col-md-6">
                        <a href="<?php echo admin_url('accounting/rp_employee_contact_list'); ?>"><?php echo _l('employee_contact_list'); ?></a>
                      <p><?php echo _l('employee_contact_list_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_recent_edited_time_activities'); ?>"><?php echo _l('recent_edited_time_activities'); ?></a>
                      <p><?php echo _l('recent_edited_time_activities_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_time_activities_by_employee_detail'); ?>"><?php echo _l('time_activities_by_employee_detail'); ?></a>
                      <p><?php echo _l('time_activities_by_employee_detail_note'); ?></p>
                    </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="panel-group hide">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse6"><?php echo _l('payroll'); ?></a>
                </h4>
              </div>
              <div id="collapse6" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                     <div class="col-md-6">
                        <a href="<?php echo admin_url('accounting/rp_employee_contact_list'); ?>"><?php echo _l('employee_contact_list'); ?></a>
                      <p><?php echo _l('employee_contact_list_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_recent_edited_time_activities'); ?>"><?php echo _l('recent_edited_time_activities'); ?></a>
                      <p><?php echo _l('recent_edited_time_activities_note'); ?></p>
                        <a href="<?php echo admin_url('accounting/rp_time_activities_by_employee_detail'); ?>"><?php echo _l('time_activities_by_employee_detail'); ?></a>
                      <p><?php echo _l('time_activities_by_employee_detail_note'); ?></p>
                    </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
</body>
</html>
