<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    ################################AddUser##################################
    function addUser($data){
	
		$row = $this->createRow();
		$row->username = $data['username'];
		$row->useremail = $data['useremail'];
		$row->password= md5($data['password']);
		$row->picture= $data['picture'];
		$row->signatuer= $data['signature'];
		$row->gender= $data['gender'];
		$row->country= $data['country'];
		return $row->save();
	}
	###############################DeleteUser#####################################
	public function deleteUser($id)
    {
       
        return $this->delete('user_id='.$id);
    
    } 
    #######################3List User#################
    function listUsers(){
		return $this->fetchAll()->toArray();

	}
	#########################EDit User################################
	function getUserById($id){
		return $this->find($id)->toArray();
	}

	//-------------------------------------------- 
	function editUser($id,$data){
     if (isset($data['module']))  
		unset( $data['module']) ;
	if (isset($data['controller'])) 
 		unset( $data['controller']);
	if (isset($data['action']))
		 unset( $data['action']);
	if (isset($data['submit']))
		 unset( $data['submit']);
	$where = "user_id = " . $id;

   return  $this->update($data, $where );


	}

#################################SEt ADmin##########################
	function adminUser($id){
   $data = array(
    'admin' => 1);
   $where = "user_id = " . $id;		
	
  return  $this->update($data, $where );

}
#################33Remove Admininstration and return it to regular  User#####################
<<<<<<< HEAD
	function removeadminUser($id){
   		$data = array(
    	'admin' => 0);
   		$where = "user_id = " . $id;
  		return  $this->update($data, $where );
	}
=======
function removeadminUser($id){
   $data = array(
    'admin' => 0);
   $where = "user_id = " . $id;
  return  $this->update($data, $where );

}
>>>>>>> 29bbea56dfd713027a05ef1a0f7da92d37b9a7bc
########################################Ban Users#######################################
	function banUser($id){
   		$data = array(
    	'ban' => 1);
   		$where = "user_id = " . $id;
  		return  $this->update($data, $where );

<<<<<<< HEAD
	}

function getUserByEmail($email)
	{
		//return $this->find($id)->toArray();
		$select = $this->select()->where("useremail='".$email."'");
		return $this->fetchAll($select);
	}


=======
  return  $this->update($data, $where );

}
#############################Remove Ban Action#########################################
function removeban($id){
   $data = array(
    'ban' => 0);
   $where = "user_id = " . $id;

		
	
  return  $this->update($data, $where );

}

////---------------------- get  email ---------------------
	function getUserByEmail($email){
		return $this->find($email)->toArray();

	}
// ------------- registration user -------------------------
	function registration($data){
		
		$row = $this->createRow();
		$row->username = $data['username'];
		$row->useremail = $data['useremail'];
		$row->password= md5($data['password']);
		$row->picture= $data['picture'];
		$row->gender= $data['gender'];
		$row->country= $data['country'];
		$row->ban=0;
		$row->admin=0;
		$row->systemclosed=0;
		return $row->save();
	}


	function edituserProfile($id,$data){

		//$row = $this->createRow();
		if(isset($data['module']))
			unset($data['module']);
		if(isset($data['MAX_FILE_SIZE']))
			unset($data['MAX_FILE_SIZE']);
		if(isset($data['controller']))
			unset($data['controller']);
		if(isset($data['action']))
			unset($data['action']);
		if(isset($data['save']))
			unset($data['save']);
		if(isset($data['id']))
			unset($data['id']);
		$data['password']=md5($data['password']);
		//$data['picture']=$data['picture'];
		if(isset($data['userId']))
			unset($data['userId']);

		return $this->update($data,'user_id='.$id);

	}


	function changepassword($id,$data){

		if(isset($data['module']))
			unset($data['module']);
		if(isset($data['controller']))
			unset($data['controller']);
		if(isset($data['action']))
			unset($data['action']);
		if(isset($data['SavePassword']))
			unset($data['SavePassword']);

		if(isset($data['oldpassword']))
			unset($data['oldpassword']);

		if(isset($data['confpassword']))
			unset($data['confpassword']);

		if(isset($data['id']))
			unset($data['id']);
		$data['password']=md5($data['password']);
		if(isset($data['userId']))
			unset($data['userId']);

		return $this->update($data,'user_id='.$id);

	}



>>>>>>> 29bbea56dfd713027a05ef1a0f7da92d37b9a7bc
}
	