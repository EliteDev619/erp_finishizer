<?php

defined('BASEPATH') or exit('No direct script access allowed');

add_option('acc_first_month_of_financial_year', 'January');
add_option('acc_first_month_of_tax_year', 'same_as_financial_year');
add_option('acc_accounting_method', 'accrual');
add_option('acc_close_the_books', 0);
add_option('acc_allow_changes_after_viewing', 'allow_changes_after_viewing_a_warning');
add_option('acc_close_book_password');
add_option('acc_close_book_passwordr');
add_option('acc_enable_account_numbers', 0);
add_option('acc_show_account_numbers', 0);
add_option('acc_closing_date');

add_option('acc_add_default_account', 0);
add_option('acc_add_default_account_new', 0);
add_option('acc_invoice_automatic_conversion', 1);
add_option('acc_payment_automatic_conversion', 1);
add_option('acc_expense_automatic_conversion', 1);
add_option('acc_tax_automatic_conversion', 1);

add_option('acc_invoice_payment_account', 66);
add_option('acc_invoice_deposit_to', 1);
add_option('acc_payment_payment_account', 1);
add_option('acc_payment_deposit_to', 13);
add_option('acc_expense_payment_account', 13);
add_option('acc_expense_deposit_to', 37);
add_option('acc_tax_payment_account', 29);
add_option('acc_tax_deposit_to', 1);
add_option('acc_expense_tax_payment_account', 13);
add_option('acc_expense_tax_deposit_to', 29);

add_option('acc_active_payment_mode_mapping', 1);
add_option('acc_active_expense_category_mapping', 1);

if (!$CI->db->table_exists(db_prefix() . 'acc_accounts')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_accounts` (
  	  `id` INT(11) NOT NULL AUTO_INCREMENT,
	  `name` VARCHAR(255) NOT NULL,
    `key_name` VARCHAR(255) NULL,
	  `number` VARCHAR(45) NULL,
	  `parent_account` INT(11) NULL,
	  `account_type_id` INT(11) NOT NULL,
	  `account_detail_type_id` INT(11) NOT NULL,
	  `balance` DECIMAL(15,2) NULL,
	  `balance_as_of` DATE NULL,
	  `description` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_account_history')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_account_history` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `account` INT(11) NOT NULL,
      `debit` DECIMAL(15,2) NOT NULL DEFAULT 0,
      `credit` DECIMAL(15,2) NOT NULL DEFAULT 0,
      `description` TEXT NULL,
      `rel_id` INT(11) NULL,
      `rel_type` VARCHAR(45) NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      `customer` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_transfers')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_transfers` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `transfer_funds_from` INT(11) NOT NULL,
      `transfer_funds_to` INT(11) NOT NULL,
      `transfer_amount` DECIMAL(15,2) NULL,
      `date` VARCHAR(45) NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_journal_entries')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_journal_entries` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `number` VARCHAR(45) NULL,
      `description` TEXT NULL,
      `journal_date` DATE NULL,
      `amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_transaction_bankings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_transaction_bankings` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `date` DATE NOT NULL,
      `withdrawals` DECIMAL(15,2) NOT NULL DEFAULT 0,
      `deposits` DECIMAL(15,2) NOT NULL DEFAULT 0,
      `payee` VARCHAR(255) NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_reconciles')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_reconciles` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `account` INT(11) NOT NULL,
      `beginning_balance` DECIMAL(15,2) NOT NULL,
      `ending_balance` DECIMAL(15,2) NOT NULL,
      `ending_date` DATE NOT NULL,
      `expense_date` DATE NULL,
      `service_charge` DECIMAL(15,2) NULL,
      `expense_account` INT(11) NULL,
      `income_date` DATE NULL,
      `interest_earned` DECIMAL(15,2) NULL,
      `income_account` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('reconcile' ,db_prefix() . 'acc_account_history')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_account_history`
    ADD COLUMN `reconcile` INT(11) NOT NULL DEFAULT 0;');
}

if (!$CI->db->field_exists('finish' ,db_prefix() . 'acc_reconciles')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_reconciles`
    ADD COLUMN `finish` INT(11) NOT NULL DEFAULT 0;');
}

if (!$CI->db->field_exists('split' ,db_prefix() . 'acc_account_history')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_account_history`
    ADD COLUMN `split` INT(11) NOT NULL DEFAULT 0;');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_banking_rules')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_banking_rules` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(255) NOT NULL,
      `transaction` VARCHAR(45) NULL,
      `following` VARCHAR(45) NULL,
      `then` VARCHAR(45) NULL,
      `payment_account` INT(11) NULL,
      `deposit_to` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_banking_rule_details')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_banking_rule_details` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `rule_id` INT(11) NOT NULL,
      `type` VARCHAR(45) NULL,
      `subtype` VARCHAR(45) NULL,
      `text` VARCHAR(255) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('auto_add' ,db_prefix() . 'acc_banking_rules')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_banking_rules`
    ADD COLUMN `auto_add` INT(11) NOT NULL DEFAULT 0;');
}

if (!$CI->db->field_exists('subtype_amount' ,db_prefix() . 'acc_banking_rule_details')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_banking_rule_details`
    ADD COLUMN `subtype_amount` VARCHAR(45) NULL;');
}

if (!$CI->db->field_exists('default_account' ,db_prefix() . 'acc_accounts')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_accounts`
    ADD COLUMN `default_account` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `active` INT(11) NOT NULL DEFAULT 1;');
}

if (!$CI->db->field_exists('item' ,db_prefix() . 'acc_account_history')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_account_history`
    ADD COLUMN `item` INT(11) NULL,
    ADD COLUMN `paid` INT(1) NOT NULL DEFAULT 0;');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_item_automatics')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_item_automatics` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `item_id` INT(11) NOT NULL,
      `inventory_asset_account` INT(11) NOT NULL DEFAULT 0,
      `income_account` INT(11) NOT NULL DEFAULT 0,
      `expense_account` INT(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_tax_mappings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_tax_mappings` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `tax_id` INT(11) NOT NULL,
      `payment_account` INT(11) NOT NULL DEFAULT 0,
      `deposit_to` INT(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('date' ,db_prefix() . 'acc_account_history')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_account_history`
    ADD COLUMN `date` DATE NULL;');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_expense_category_mappings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_expense_category_mappings` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `category_id` INT(11) NOT NULL,
      `payment_account` INT(11) NOT NULL DEFAULT 0,
      `deposit_to` INT(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('tax' ,db_prefix() . 'acc_account_history')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_account_history`
    ADD COLUMN `tax` INT(11) NULL;');
}


if (!$CI->db->field_exists('expense_payment_account' ,db_prefix() . 'acc_tax_mappings')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_tax_mappings`
    ADD COLUMN `expense_payment_account` INT(11) NOT NULL DEFAULT \'0\',
    ADD COLUMN `expense_deposit_to` INT(11) NOT NULL DEFAULT \'0\';');
}

if (!$CI->db->table_exists(db_prefix() . 'acc_payment_mode_mappings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_payment_mode_mappings` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `payment_mode_id` INT(11) NOT NULL,
      `payment_account` INT(11) NOT NULL DEFAULT 0,
      `deposit_to` INT(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

add_option('acc_payment_expense_automatic_conversion', 1);
add_option('acc_payment_sale_automatic_conversion', 1);
add_option('acc_expense_payment_payment_account', 1);
add_option('acc_expense_payment_deposit_to', 1);

if (!$CI->db->table_exists(db_prefix() . 'acc_account_type_details')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "acc_account_type_details` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `account_type_id` INT(11) NOT NULL,
      `name` VARCHAR(255) NOT NULL,
      `note` TEXT NULL,
      `statement_of_cash_flows` VARCHAR(255) NULL,
      PRIMARY KEY (`id`)
    ) AUTO_INCREMENT=200, ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('preferred_payment_method' ,db_prefix() . 'acc_expense_category_mappings')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_expense_category_mappings`
    ADD COLUMN `preferred_payment_method` INT(11) NOT NULL DEFAULT \'0\';');
}

if (!$CI->db->field_exists('expense_payment_account' ,db_prefix() . 'acc_payment_mode_mappings')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_payment_mode_mappings`
    ADD COLUMN `expense_payment_account` INT(11) NOT NULL DEFAULT \'0\',
    ADD COLUMN `expense_deposit_to` INT(11) NOT NULL DEFAULT \'0\';');
}

if (get_option('acc_expense_deposit_to') == 37){
  update_option('acc_expense_deposit_to', 80);
}