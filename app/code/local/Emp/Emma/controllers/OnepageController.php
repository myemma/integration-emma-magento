
<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Emp_Emma_OnepageController extends Mage_Checkout_OnepageController
{
    public function saveBillingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        
        if ($this->getRequest()->isPost()) {
//            $postData = $this->getRequest()->getPost('billing', array());
//            $data = $this->_filterPostData($postData);
            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            if (isset($data['email'])) {
                $data['email'] = trim($data['email']);
            }
            if ($this->getRequest()->getParam('is_subscribed', false)) {
                $status = Mage::getModel('newsletter/subscriber')->subscribe($data['email']);
                $emma_table_model = Mage::getModel('emma/emmasync');
                $emma_data = $emma_table_model->load(1);;    
                $groups_ids=json_decode($emma_data->groups);        
                foreach($groups_ids as $groups_id)
                {
                    $groups_list[]=(integer)$groups_id;
                }     
                 $emma_object=Mage::getModel('emma/EMMAAPI'); 
                // $fields=array('first_name'=>'')
                $members = array( array('email'=>$data['email']));
                $response = $emma_object->import_member_list($members, 'emma_register_add', 1, $groups_list);                   
            }
            else
            {
                $emma_object=Mage::getModel('emma/EMMAAPI'); 
                $member_details=$emma_object->get_member_detail_by_email($data['email']);
                if(isset($member_details->member_id)&& ($member_details->member_id))
                {
                    $response=$emma_object->remove_member_from_all_groups($member_details->member_id);
                }            
            }
            $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

            if (!isset($result['error'])) {
                /* check quote for virtual */
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

                    $result['allow_sections'] = array('shipping');
                    $result['duplicateBillingInfo'] = 'true';
                } else {
                    $result['goto_section'] = 'shipping';
                }
            }
         /*   if ($this->getRequest()->getParam('is_subscribed', false)) {    
                if (!$customer = Mage::registry('current_customer')) {
                    $customer = Mage::getModel('customer/customer')->setId(null);
                }
            
                $customer->setIsSubscribed(1);
            }*/
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
}
