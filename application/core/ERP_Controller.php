<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @deprecated 2.3.2
 * Use App_Controller instead
 */
class ERP_Controller extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        _deprecated_function('ERP_Controller', '2.3.2', 'App_Controller');
    }
}
