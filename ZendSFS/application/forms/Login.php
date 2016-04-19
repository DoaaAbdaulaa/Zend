<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $email=new Zend_Form_Element_Text("email");
        $email->setRequired();
        $email->setLabel("Email  :");
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->setAttrib("placeholder","Enter your email");
        $email->setAttrib("class","form-control");
//--------------------------------------------------------------------------------
        // for  input password  
        $password=new Zend_Form_Element_Password('password');
        $password->setRequired();
        $password->setLabel("Password :");
        $password->setAttrib("class","form-control");
        $password->setAttrib("placeholder","Enter your password");
        $password->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>15)));
//---------------------------------------------------------------------------- 
        $submit=new Zend_Form_Element_Submit('submit');  
        $submit->setAttrib("class","form-control  btn btn-info");
//---------------------------------------------------------------------------------------------
        // add componnent  
        $this->setAttrib("class","form-horizontal");
        $this->addElements(array($email,$password,$submit));





    }


}

