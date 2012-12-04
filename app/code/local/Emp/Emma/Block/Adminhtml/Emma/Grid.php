<?php
 
class Emp_Emma_Block_Adminhtml_Emma_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('emmaGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('emma/emmasync')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
          'header'    => Mage::helper('emma')->__('ID'),
          'align'     =>'right',
          'width'     => '10px',
          'index'     => 'id',
        ));
 
        $this->addColumn('groups', array(
          'header'    => Mage::helper('emma')->__('Groups'),
          'align'     =>'left',
          'index'     => 'groups',
          'width'     => '50px',
        ));
        return parent::_prepareColumns();
    }
}