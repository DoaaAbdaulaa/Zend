<?php

class Application_Model_DbTable_SubCategory extends Zend_Db_Table_Abstract
{

    protected $_name = 'sub_category';


	function list_sub_category($id)
	{
		//return $this->find($id)->toArray();
		$select = $this->select()->where('cat_id='.$id);
		return $this->fetchAll($select);

	}

	function addFourm($data)
	{
		if(isset($data['module']))
			unset($data['module']);
		if(isset($data['controller']))
			unset($data['controller']);
		if(isset($data['action']))
			unset($data['action']);
		if(isset($data['submit']))
			unset($data['submit']);
		if(isset($data['post']))
			unset($data['post']);
		if (isset($data['Add']))
		{
			unset($data['Add']);
		}
		
		$data['sub_cat_time'] =  new Zend_Db_Expr('NOW()');	
		$data['ban_thread'] = 0;
			
		return $this->insert($data);
	}


}

