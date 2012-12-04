
<?php
require_once 'Mage/Newsletter/controllers/ManageController.php';
class Emp_Emma_ManageController extends Mage_Newsletter_ManageController
{
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }

    public function saveAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('customer/account/');
        }
        try {
            Mage::getSingleton('customer/session')->getCustomer()
            ->setStoreId(Mage::app()->getStore()->getId())
            ->setIsSubscribed((boolean)$this->getRequest()->getParam('is_subscribed', false))
            ->save();
            if ((boolean)$this->getRequest()->getParam('is_subscribed', false)) {
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                $emma_table_model = Mage::getModel('emma/emmasync');
                $data = $emma_table_model->load(1);;    
                $groups_ids=json_decode($data->groups);        
                foreach($groups_ids as $groups_id)
                {
                    $groups_list[]=(integer)$groups_id;
                }     
                 $emma_object=Mage::getModel('emma/EMMAAPI'); 
                // $fields=array('first_name'=>'')
                $members = array( array('email'=>$customer->getEmail()));
                $response = $emma_object->import_member_list($members, 'emma_register_add', 1, $groups_list);  
                Mage::getSingleton('customer/session')->addSuccess($this->__('The subscription has been saved.'));
            } else {
                    $emma_object=Mage::getModel('emma/EMMAAPI'); 
                    $customer = Mage::getSingleton('customer/session')->getCustomer();
                    $member_details=$emma_object->get_member_detail_by_email($customer->getEmail());
                    if(isset($member_details->member_id)&& ($member_details->member_id))
                    {
                        $response=$emma_object->remove_member_from_all_groups($member_details->member_id);
                    }
                Mage::getSingleton('customer/session')->addSuccess($this->__('The subscription has been removed.'));
            }
        }
        catch (Exception $e) {
            Mage::getSingleton('customer/session')->addError($this->__('An error occurred while saving your subscription.'));
        }
        $this->_redirect('customer/account/');
    }
}
