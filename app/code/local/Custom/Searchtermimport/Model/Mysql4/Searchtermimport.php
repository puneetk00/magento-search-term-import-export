<?php
class Custom_Searchtermimport_Model_Mysql4_Searchtermimport extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("searchtermimport/searchtermimport", "id");
    }
}