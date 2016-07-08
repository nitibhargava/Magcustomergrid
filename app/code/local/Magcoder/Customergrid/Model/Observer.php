<?php
Class Magcoder_Customergrid_Model_Observer{
	/*
	 * Purpose: Append new column to customer grid
	 * Params: Varien_Event_Observer $observer
	 * return: Magcoder_Customergrid_Model_Observer $this
	 * */
	public function addCompanyColumn(Varien_Event_Observer $observer){
		$block=$observer->getBlock();
		if(!isset($block)){ //Check if type is block
				return $this;
		}
		if($block->getType()=='adminhtml/customer_grid'){ // Check if customer grid block object
			$block->addColumnAfter('billing_company',array( //Add after telephone column
				'header'=>'Company',
				'type'=>'text',
				'index'=>'billing_company',
				'filter'=>false,
				'sortable'=>false,
				'renderer'=>'Magcoder_Customergrid_Block_Adminhtml_Rendrer_Customercompany'
			),'Telephone');
		}
	}
}
