<?php

class Emp_Emma_Block_Adminhtml_Emma_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
      parent::__construct();
      $this->setId('form_tabs');
      $this->setDestElementId('edit_form'); // this should be same as the form id define above
      $this->setTitle(Mage::helper('emma')->__('Product Information'));
    }

    protected function _beforeToHtml()
    {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('emma')->__('Emma Lists'),
          'title'     => Mage::helper('emma')->__('Emma Lists'),
          'content'   => $this->getLayout()->createBlock('emma/adminhtml_emma_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
    }
}