<?php
class Emp_Emma_Block_Adminhtml_Emma extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_emma';
    $this->_blockGroup = 'emma';
    $this->_headerText = Mage::helper('emma')->__('Emma Manager');
    $this->_addButtonLabel = Mage::helper('emma')->__('Add Emma');
    parent::__construct();
  }
}