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

    // $data = $this->getRequest()->getParams();
     if($this->getRequest()->isPost()){

      

     $data = $this->getRequest()->getParams();

     //var_dump($data);

        if($registration->isValid($data)){

            $pic1=pathinfo($registration->picture->getFileName());

             $A=$pic1['basename'];

            // echo $A;
  
             if ($registration->picture->receive()) {

                    $data['picture']=$pic1['basename'];

           if ($this->model->registration($data)){
            
                $this->redirect('users/login');

           }
                    
            }
              echo "Done register ";

    
    } 
   
    }
     
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
                    $storage->write($authAdapter->getResultRowObject(array('useremail' , 'user_id' , 'username','admin',)));

                    $idd=$auth->getIdentity()->user_id;

                    $adminn=$auth->getIdentity()->admin;
                    echo $idd;
                    echo $adminn;
                    ///// check admin or  not 
                    if($adminn==0){

                        echo "not Admin ";

                        $this->redirect('users/list/uid/'.$idd);
                    }
                    else{

                         echo " Admin ";

                         $this->redirect('users/list/uid/'.$idd);
                    }
                   // $this->redirect('users/list/uid/'.$idd); 
                }
                else{
                    echo "not valid";
                    $this->redirect('users/login'); 
                }

            }

        }

    }

    public function sendMailAction()
    {                
    $mail = new Zend_Mail();
// information of user login to send message in your  mail 
    $auth =Zend_Auth::getInstance();

    $idd=$auth->getIdentity()->user_id;

    $name=$auth->getIdentity()->username;

    $Emailuse=$auth->getIdentity()->useremail;

     $auth =Zend_Auth::getInstance();

    $idd=$auth->getIdentity()->user_id;
    // body of email 
    $mail->setBodyText('hi'.$name."<br>".'Welcome in Forums  your Email '.$Emailuse.'to change  your password http://localhost/Zend/Zend/ZendSFS/public/users/change-password/id/'.$idd);

    $mail->setFrom('forum@sfs.com', 'Forum');

    $mail->addTo($Emailuse,'Me');

    $mail->setSubject('TestSubject rererere—–');

    $mail->send();

    }
//----------------------- logout  -------------------------------------------
    public function logoutAction()
    {
        // action body
        $authAdapter=Zend_Auth::getInstance();

        $authAdapter->clearIdentity();

        $this->redirect("/users/login");  
    }
////--------------------------- change password  of  user  --------------------- 
    public function changePasswordAction()
    {
        // action body

        $change= new Application_Form_ChangePassword();

        $this->view->change=$change;

        $id=$this->getRequest()->getParam('id');

         $user = $this->model->getUserById($id);

        $old=$user[0]['password'];

           if($this->getRequest()->isPost()){ 

            $data = $this->getRequest()->getParams();

             if($change->isValid($data)){  

                $oldPass=$this->getRequest()->getParam('oldpassword');

                $newPass=$this->getRequest()->getParam('password');

                $confPass=$this->getRequest()->getParam('confpassword');

                if(($old===md5($oldPass)) &&($newPass===$confPass) ){
                    echo " Done change password ";

                    if($this->model->changepassword($id, $data)){

                        $this->redirect('users/list');

                     }
                }
                else{

                    echo "<div> <h2>old password  error </h2></div >  ";
               
                }

            }

        }

    }
///--------------------------------------- eedit  profile -------------------------- 
    public function editProfilAction()
    {
        // action body
        $editinfo=new Application_Form_Editprofile();

        $this->view->editinfo=$editinfo;

        $id=$this->getRequest()->getParam('id');

        $user = $this->model->getUserById($id);

        $editinfo->populate($user[0]);

        if($this->getRequest()->isPost())
        {   
            $data = $this->getRequest()->getParams();
            if($editinfo->isValid($data))
            {    

             $pic1=pathinfo($editinfo->picture->getFileName());
             // photo name 
             $A=$pic1['basename'];

                 if ($editinfo->picture->receive()) {

                    $data['picture']=$pic1['basename'];

                if($this->model->edituserProfile($id, $data))
                {
                    $this->redirect('users/list');
                }

            }

            }    
        
        }

    }

}