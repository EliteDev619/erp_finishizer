<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @deprecated 2.3.2
 * Use App_Model instead
 */
class ERP_Model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        _deprecated_function('ERP_Model', '2.3.2', 'App_Model');
    }
}
