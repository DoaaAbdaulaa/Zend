<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $admin=new Zend_Form_Element_Hidden("admin");

        $useremail=new Zend_Form_Element_Text("useremail");
        $useremail->setRequired();
        //$useremail->setLabel("Email  :");
        $useremail->addValidator(new Zend_Validate_EmailAddress());
        $useremail->setAttrib("placeholder","Enter your email");
        $useremail->setAttrib("class","form-control");
//--------------------------------------------------------------------------------
        // for  input password  
        $password=new Zend_Form_Element_Password('password');
        $password->setRequired();
       // $password->setLabel("Password :");
        $password->setAttrib("class","form-control");
        $password->setAttrib("placeholder","Enter your password");
        $password->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>15)));
//---------------------------------------------------------------------------- 
        $submit=new Zend_Form_Element_Submit('submit');  
        $submit->setAttrib("class","form-control  btn btn-info");
//---------------------------------------------------------------------------------------------
        // add componnent  
        $this->setAttrib("class","form-horizontal");
        $this->addElements(array($admin,$useremail,$password,$submit));





    }


}

