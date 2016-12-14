<?php


class Custom_Searchtermimport_Block_Adminhtml_Searchtermimport extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_searchtermimport";
	$this->_blockGroup = "searchtermimport";
	$this->_headerText = Mage::helper("searchtermimport")->__("Searchtermimport Manager");
	$this->_addButtonLabel = Mage::helper("searchtermimport")->__("Add New Item");
	parent::__construct();
	
	}

}