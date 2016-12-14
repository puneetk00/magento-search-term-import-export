<?php

class Custom_Searchtermimport_Adminhtml_SearchtermimportController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("searchtermimport/searchtermimport")->_addBreadcrumb(Mage::helper("adminhtml")->__("Searchtermimport  Manager"),Mage::helper("adminhtml")->__("Searchtermimport Manager"));
				return $this;
		}
		
		
		public function newAction()
		{
			$this->_title($this->__("Search Term Import"));

			$this->loadLayout();
			$this->_setActiveMenu("searchtermimport/searchtermimport");

			$this->_addContent($this->getLayout()->createBlock("searchtermimport/adminhtml_searchtermimport_edit"))->_addLeft($this->getLayout()->createBlock("searchtermimport/adminhtml_searchtermimport_edit_tabs"));

			$this->renderLayout();

		}
		
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {
							if((bool)$post_data['csv_import']['delete']==1) {
								$post_data['csv_import']='';
							}else{

								unset($post_data['csv_import']);

								if (isset($_FILES)){

									if ($_FILES['csv_import']['name']) {

										$file = $_FILES['csv_import']['name'];
										$path = Mage::getBaseDir('media') . DS . 'zone' . DS .'zoneship'.DS;
										$uploader = new Varien_File_Uploader('csv_import');
										$uploader->setAllowedExtensions(array('csv'));
										$uploader->setAllowRenameFiles(false);
										$uploader->setFilesDispersion(false);
										$destFile = $path.$_FILES['csv_import']['name'];
										$filename = $uploader->getNewFileName($destFile);
										$uploadedfile = $uploader->save($path, $filename);
										//print_r($uploadedfile['file']); die;

										$post_data['csv_import'] ='zone/zoneship/'.$filename;
										$io = new Varien_Io_File();
										$io->open(array('path' => $path));
										$io->streamOpen($path.$uploadedfile['file'], 'r');
										$io->streamLock(true);
										$delimiter=',';
										$enclosure='"';
										$map = $io->streamReadCsv($delimiter, $enclosure);
									
										while(false !== ($data = $io->streamReadCsv($delimiter, $enclosure))){
										  
											if($data){
													
													/* @var $model Mage_CatalogSearch_Model_Query */
													$model = Mage::getModel('catalogsearch/query');

													// validate query
													$queryText  = $data[0];
													$storeId    = $data[5];;

													try {
														if ($queryText){
															$model->setStoreId($storeId);
															$model->loadByQueryText($queryText);
															if ($model->getId()){
																	$model->load($model->getId());
																
															}
														}

														$model->setQueryText($data[0]);
														$model->setNumResults($data[1]);
														$model->setPopularity($data[2]);
														$model->setRedirect($data[3]);
														$model->setSynonymFor($data[4]);
														$model->setStoreId($data[5]);
														$model->setDisplayInTerms($data[6]);
														$model->setIsActive($data[7]);
														$model->setIsProcessed($data[8]);
														$model->save();

													} catch (Mage_Core_Exception $e) {
														$this->_getSession()->addError($e->getMessage());
														
													} catch (Exception $e) {
														$this->_getSession()->addException($e,
														Mage::helper('catalog')->__('An error occurred while saving the search query. %s',$e->getMessage())
														);
														
													}
														
													Mage::log($data, null, 'csv.log');
															   
																 
											}else{
												continue;
											}
										}
									}
									unlink($path.$uploadedfile['file']);
									Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Search Team were Successfully Imported "));
									Mage::getSingleton("adminhtml/session")->setZoneimportData(false);
								}else{
									Mage::getSingleton("adminhtml/session")->addError("File not Choose");
								}
							}
						
						
						$this->_redirect("*/*/new");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setZoneimportData($this->getRequest()->getPost());
						$this->_redirect("*/*/new");
					return;
					}

				}
				
				$this->_redirect("*/*/new");
		}



		
		public function downloadSampleAction() {
			$filename = '"query_text","num_results","popularity","redirect","synonym_for","store_id","display_in_terms","is_active","is_processed"
				"red t shirt","5","2196",,,"1","1","1","1"
				"my t shirt",60,"1","http://www.commerceextensions.com/magento-mport-export-bulk-magento-wishlist-items-csv-xml.html",,"1","0","1","0"
				';
			$this->_prepareDownloadResponse('import_searchterm_sample.csv', $filename);
		}
		
		public function downloadExportAction() {
			$model = Mage::getModel('catalogsearch/query')->getCollection();
			$csv = '';
			foreach($model as $row){
						$csv .= '"'. $row->getQueryText() . '",';
						$csv .= '"'.$row->getNumResults(). '",';
						$csv .= '"'.$row->getPopularity(). '",';
						$csv .= '"'.$row->getRedirect(). '",';
						$csv .= '"'.$row->getSynonymFor(). '",';
						$csv .= '"'.$row->getStoreId(). '",';
						$csv .= '"'.$row->getDisplayInTerms(). '",';
						$csv .= '"'.$row->getIsActive(). '",';
						$csv .= '"'.$row->getIsProcessed(). '"';
						$csv .= "\n";
			}
			$filename = '"query_text","num_results","popularity","redirect","synonym_for","store_id","display_in_terms","is_active","is_processed"' . "\n";
			$filename .= $csv;
			$this->_prepareDownloadResponse('search_term.csv', $filename);
		}
		
			
		
		
}
