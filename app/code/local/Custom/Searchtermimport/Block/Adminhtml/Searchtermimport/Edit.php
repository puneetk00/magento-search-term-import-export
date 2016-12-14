<?php
	
class Custom_Searchtermimport_Block_Adminhtml_Searchtermimport_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "searchtermimport";
				$this->_controller = "adminhtml_searchtermimport";
				$this->_removeButton('save');
				$this->_removeButton('delete');
				$this->_removeButton('reset');
				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("searchtermimport")->__("Import"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "import",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				// if( Mage::registry("searchtermimport_data") && Mage::registry("searchtermimport_data")->getId() ){

				    // return Mage::helper("searchtermimport")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("searchtermimport_data")->getId()));

				// } 
				// else{

				     // return Mage::helper("searchtermimport")->__("Add Item");

				// }
				return;
		}
}