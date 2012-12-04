<?php
    class Emp_Emma_Model_Mysql4_Emmasync extends Mage_Core_Model_Mysql4_Abstract
    {
        protected function _construct()
        {
            $this->_init("emma/emmasync", "id");
        }
    }
	 