<?php
class Custom_Searchtermimport_Block_Adminhtml_Searchtermimport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("searchtermimport_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("searchtermimport")->__("Search Term Import"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("searchtermimport")->__("Search Term Import"),
				"title" => Mage::helper("searchtermimport")->__("Search Term Import"),
				"content" => $this->getLayout()->createBlock("searchtermimport/adminhtml_searchtermimport_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
