<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_user_addr extends MY_Model {

    private $_table = 't_user_addr';

    public function __construct() {
        parent::__construct($this->_table);
    }

  }