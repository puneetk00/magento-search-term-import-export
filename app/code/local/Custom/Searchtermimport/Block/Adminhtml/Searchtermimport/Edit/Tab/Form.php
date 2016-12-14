<?php
class Custom_Searchtermimport_Block_Adminhtml_Searchtermimport_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("zoneship_form", array("legend"=>Mage::helper("searchtermimport")->__("Search Term Import")));

				
						$fieldset->addField('csv_import', 'image', array(
						'label' => Mage::helper('searchtermimport')->__('Csv Import File'),
						'name' => 'csv_import',
						'note' => '(*.csv)',
						));
						$fieldset->addField('sample', 'note', array(
							'label' => Mage::helper('searchtermimport')->__('Download Sample CSV File'),
							'text'  => '<a href="'.
									$this->getUrl('*/*/downloadSample').
									'" title="'.
									Mage::helper('searchtermimport')->__('Download Sample CSV File').
									'">import_bulk_searchterms.csv</a>'
						));
						
				$export = $form->addFieldset("zoneship_export", array("legend"=>Mage::helper("searchtermimport")->__("Search Term Export")));
				
				$export->addField('export', 'note', array(
					'label' => Mage::helper('searchtermimport')->__('Download Search Term CSV File'),
					'text'  => '<a href="'.
							$this->getUrl('*/*/downloadExport').
							'" title="'.
							Mage::helper('searchtermimport')->__('Export CSV File').
							'">Export Data</a>'
				));

				if (Mage::getSingleton("adminhtml/session")->getZoneshipimportData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getZoneshipimportData());
					Mage::getSingleton("adminhtml/session")->setZoneshipimportData(null);
				} 
				elseif(Mage::registry("zoneshipimport_data")) {
				    $form->setValues(Mage::registry("zoneshipimport_data")->getData());
				}
				return parent::_prepareForm();
		}
}
