<?php

class SubCategoryController extends Zend_Controller_Action
{
	private $model;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_SubCategory();
    }

    public function indexAction()
    {
        // action body
    }

    public function addfourmAction()
    {
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Subcategory();
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        if($user->admin == 1)
        {	
        	$data['sub_cat_user_id']=$user->user_id;
        	if($this->getRequest()->isPost())
        	{
        		if($form->isValid($data))
        		{
        			if($this->model->addFourm($data))
                	{
                    	$this->redirect('Usercategory/listcategory/user_id/'.$user->user_id);
                	}
        		}

        	}	

        	$this->view->form = $form;

    	}
    	else
    	{
    		$this->redirect('/users/login');
    	}	
    }


}



