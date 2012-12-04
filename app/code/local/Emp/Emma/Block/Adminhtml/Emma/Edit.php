<?php

class Emp_Emma_Block_Adminhtml_Emma_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
 
        $this->_objectId = 'id';
        $this->_blockGroup = 'emma';
        $this->_controller = 'adminhtml_emma';
 
        $this->_updateButton('save', 'label', Mage::helper('emma')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('emma')->__('Delete'));

        $this->_removeButton('reset');
        $this->_removeButton('back');
    }
 
    public function getHeaderText()
    {
        return Mage::helper('emma')->__('Select your emma list');
    }
}