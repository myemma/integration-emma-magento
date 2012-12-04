<?php
class Emp_Emma_Adminhtml_EmmaController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction() {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('emma/adminhtml_emma_edit'))->_addLeft($this->getLayout()->createBlock('emma/adminhtml_emma_edit_tabs'));
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('emma/adminhtml_emma_edit'))->_addLeft($this->getLayout()->createBlock('emma/adminhtml_emma_edit_tabs'));
        $this->renderLayout();
    }
    
    public function saveAction() 
    {
        if ($data = $this->getRequest()->getPost()) 
        {
            //$object=Mage::getModel('emma/emmasync');
            //
            
            foreach($data['emma_list'] as $val)
            {
            
                $group_ids[]=(integer)($val);
            }

            $json_data=json_encode($data['emma_list']);
            
            $data=array(
                    'id'=>1,
                    'groups'=>$json_data,
                   'sync_existing'=>$data['sync_existing']?$data['sync_existing']:0
                    );
            $object=Mage::getModel('emma/emmasync')->load(1)->addData($data);
            $object->setId(1)->save();
            /*foreach($data['emma_list'] as $val)
            {
                
                $object->setName($val);
                $object->save();
            }*/
            if($data['sync_existing'])
            {
                $news_letter_collection = Mage::getResourceSingleton('newsletter/subscriber_collection');        
                foreach($news_letter_collection as $data)
                {
                    $subscribed_emails[]=array(
                        'email'=>($data->getEmail()),
                    );
                }            
                $emma_object=Mage::getModel('emma/EMMAAPI');      
               // $groups = array(244024);
                $response=$emma_object->import_member_list($subscribed_emails, 'emma_sync_import', 1, $group_ids);              
            }
           Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('emma')->__('Successfully configured Emma groups !!!'));
           $this->_redirect('*/*/index');           
        }
    }
    
}