<?php

class UsersController extends Zend_Controller_Action
{  private $model;
    public function init()
    {
         $this->model = new Application_Model_DbTable_Users();
    }

    

    public function indexAction()
    {
       // $this->redirect('users/list');
        
    }
    ###############33AddUser##############333
    public function addAction()
    {
	$data = $this->getRequest()->getParams();
	$form = new Application_Form_Adduser();
	
	if($this->getRequest()->isPost()){
		if($form->isValid($data)){
		if ($this->model->addUser($data)){
		$this->redirect('users/list');}
	}	
	}
	$this->view->flag = 1;
	$this->view->form = $form;
	$this->render('adduser');

}
 #################################List Users#########################
public function listAction()
    {
       $this->view->Users = $this->model->listUsers();
    }
###############################333Delete Users###########################
    public function deleteAction()
    {
     $id = $this->getRequest()->getParam('user_id');
      if($this->model->deleteUser($id)){
         $this->redirect('Users/list');
    }
    
    else{
   
  $this->redirect('Users/index');
}  

}
#######################################Edit User################################
public function editAction()
    {
    $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $form = new Application_Form_Edituser();
    $post = $this->model->getUserById($id);
    $form->populate($post[0]);
     $this->view->form = $form;
    
    if($this->getRequest()->isPost()){

        if($form->isValid($data)){

        if($this->model->editUser($id,$data)){
         $this->redirect('Users/list');
}
    }
    else{
   
    $this->render('edit');
}  
    }

    }
    #################################Set Admin###################
    public function adminAction()
    {
    $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->adminUser($id);
    $this->redirect('Users/list');
    
    }
    ########################33List Admin####################
     public function listadminAction()
    {
       $this->view->Users = $this->model->listUsers();
    
 
    
    }
    ######################################REmove Admin
     public function removeadminAction()
    {
    
     $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->removeadminUser($id);
    $this->redirect('Users/listadmin');
 
    
    }
    #################################################Ban Action#########################

    public function banAction()
    {
    $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->banUser($id);
    $this->redirect('Users/list');
    
    }
    ####################################################Display Ban List###############
     public function banlistAction()
    {
    $this->view->Users = $this->model->listUsers();
    
    }
    ######################################Remove Ban##############
     public function removebanAction()
    {
    
        $data = $this->getRequest()->getParams();
        $id = $this->getRequest()->getParam('user_id');
        $this->model->removeban($id);
        $this->redirect('Users/list');
     
    
    }


}

