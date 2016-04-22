<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $cat_id = new Zend_Form_Element_Hidden('cat_id');


    	$cat_title = new Zend_Form_Element_Text('cat_title');
    	$cat_title->setRequired();
    	$cat_title->setLabel("Category Title :");
    	$cat_title->setAttrib("placeholder","Enter your Category title");


    	$submit = new Zend_Form_Element_Submit('Add');

    	$this->addElements(array($cat_id,$cat_title,$submit));
    }


}

