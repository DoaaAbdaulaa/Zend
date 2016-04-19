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

     $registration= new Application_Form_Registration() ;

     $this->view->registration=$registration;

        
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

    public function banlistAction()
    {
    $this->view->Users = $this->model->listUsers();
    
    }

    public function removebanAction()
    {
    
        $data = $this->getRequest()->getParams();
        $id = $this->getRequest()->getParam('user_id');
        $this->model->removeban($id);
        $this->redirect('Users/list');
     
    
    }

    public function loginAction()
    {
        // action body

       $login=new  Application_Form_Login ();

       $this->view->login=$login;

        $useremail= $this->_request->getParam('useremail');

        $password= $this->_request->getParam('password');

        $data=$this->getRequest()->getParams();

        if($this->getRequest()->isPost()){

            if($login->isValid($data)){
                 // get the default db adapter
                $db =Zend_Db_Table::getDefaultAdapter();

                // create  auther  table 
                $authAdapter = new Zend_Auth_Adapter_DbTable($db,'users','useremail','password');
                // to compare  between use information 
                $authAdapter->setIdentity($useremail);
                
                $authAdapter->setCredential(md5($password));

                // reslte  to check information is  valied  or  not  by  ( isValid() )
                $result = $authAdapter->authenticate();

                var_dump($result);
                if($result->isValid()){
                    echo "valid user";
                    //save information to user 
                    $dataUser=$this->model->getUserByEmail($useremail);
                    //echo $dataUser[0]['id']; 
                    $auth =Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(array('useremail' , 'user_id' , 'username')));
                    //var_dump( $auth->getIdentity()->id );
                    //var_dump($auth->getIdentity()->id);
                    $idd=$auth->getIdentity()->user_id;
                    echo $idd;
                    $this->redirect('users/list/uid/'.$idd); 
                }
                else{
                    echo "not valid";
                    $this->redirect('users/login'); 
                }

            }

        }

    }


}



