<?php

class Emp_Emma_Block_Adminhtml_Emma_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $emma_object=Mage::getModel('emma/EMMAAPI');      
        $groups=$emma_object->list_groups('g,t');  
        $emma_table_model = Mage::getModel('emma/emmasync');
        $data = $emma_table_model->load(1);;    
        $groups_ids=json_decode($data->groups);        
        foreach($groups as $group)
        {
            $groups_list[]=array(
                'value'=>$group->member_group_id,
                'label'=>$group->group_name,
            );
        }
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('form_form',array('legend'=>Mage::helper('emma')->__('Magento subscribers will be added to selected groups')));
       /* $fieldset->addField('title', 'hidden', array(
                  'disabled' => false,
                  'readonly' => true,
                  'after_element_html' => '<table>
        <tr><td>Selected Groups are Mittu And Manu</td><tr>
        </table>',
                  'tabindex' => 1
                ));  */   
        $fieldset->addField('multiselect2', 'multiselect', array(
          'label'     => Mage::helper('emma')->__('Select Emma Groups'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'emma_list',
          'onclick' => "return false;",
          'onchange' => "return false;",
          'value'  => $groups_ids,
          'values' => $groups_list,
          'disabled' => false,
          'readonly' => false,
          'tabindex' => 1
        ));
$fieldset->addField('checkbox', 'checkbox', array(
          'label'     => Mage::helper('emma')->__('Sync existing users also'),
          'name'      => 'sync_existing',
          'checked' => $data->sync_existing?true:false,
          'onclick' => "",
          'onchange' => "",
          'value'  => '1',
          'disabled' => false,
          'tabindex' => 1
        ));        
        return parent::_prepareForm();
    }
}