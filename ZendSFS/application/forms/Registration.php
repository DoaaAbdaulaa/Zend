<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("class","form-horizontal");

        // input email 
        $useremail=new Zend_Form_Element_Text("useremail");
        $useremail->setRequired();
        $useremail->setlable("Email :")
        $useremail->addValidator(new Zend_Validate_EmailAddress());
     	$useremail->setAttrib("placeholder","Enter your email");
        $useremail->setAttrib("class","form-control");
    	
    	// input user name 
    	$username=new  Zend_Form_Element_Text("username");
    	$username->setRequired();
    	$username->setlable("User Name :");
    	$username->addValidator(new Zend_Validate_Alphaptical());
    	$username->setAttrib("placeholder","Enter your username");
    	$username->setAttrib("class","form-control");
    	
    	//input password  
    	$password=new  Zend_Form_Element_Password('password');
    	$password->setRequired();
    	$password->setlable("Password :");
    	$password->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>15)));
    	$password->setAttrib("placeholder","Enter your password");
    	$password->setAttrib("class","form-control");

    	// buttin submit 
    	$submit=new Zend_Form_Element_Submit('submit');
    	$submit->setAttrib("class","form-control  btn btn-info");
        
        // add componnent    
        $this->addElements(array($username,$useremail,$password,$submit));

    }
}

