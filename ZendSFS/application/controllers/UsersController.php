<?php

class UsersController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
         $this->model = new Application_Model_DbTable_Users();
    }

    public function indexAction()
    {
       // $this->redirect('users/list');
        
    }

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

    public function listAction()
    {
       $this->view->Users = $this->model->listUsers();
    }

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

    public function adminAction()
    {
    $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->adminUser($id);
    $this->redirect('Users/list');
    
    }

    public function listadminAction()
    {
       $this->view->Users = $this->model->listUsers();
    
 
    
    }

    public function removeadminAction()
    {
    
     $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->removeadminUser($id);
    $this->redirect('Users/listadmin');
 
    
    }

    public function banAction()
    {
    $data = $this->getRequest()->getParams();
    $id = $this->getRequest()->getParam('user_id');
    $this->model->banUser($id);
    $this->redirect('Users/list');
    
    }

    public function loginAction()
    {
        $data = $this->getRequest()->getParams();
        $useremail = $this->_request->getParam('useremail');
        $password = $this->_request->getParam('password');
        $form = new Application_Form_LoginUser();
        if($this->getRequest()->isPost())
        {
            if($form->isValid($data))
            {
                $db = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($db,'users','useremail','password');
                $authAdapter->setIdentity($useremail);
                $authAdapter->setCredential(md5($password));
                $result = $authAdapter->authenticate();
                if ($result->isValid())
                {
                    $user = $this->model->getUserByEmail($useremail);
                    if($user[0]['ban']==1 || $user[0]['systemclosed']==1)
                    {
                        echo "you can't login ";
                    }
                    else
                    {
                        $userdata=new Zend_Session_Namespace( 'userdata' );
                        $userdata->id=$user[0]['user_id'];
                        $auth =Zend_Auth::getInstance();
                        $storage = $auth->getStorage();
                        $storage->write($authAdapter->getResultRowObject(array('useremail' , 'user_id' , 'username','admin')));
                        $this->redirect('Usercategory/listcategory/user_id/'.$user[0]['user_id']);

                    }    

                }
                else
                {
                    echo "invalid username or password";
                }    


            }    


        }

       $this->view->form = $form; 
    }


}



