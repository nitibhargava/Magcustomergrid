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
				'filter_condition_callback'=>array($this,'companyFilterCallback')
			),'Telephone');
		}
	}
	
	/*
	 * Purpose: Modify customer grid collection data
	 * Params: Varien_Event_Observer $observer
	 * return: Magcoder_Customergrid_Model_Observer $this
	 * */
	 
	public function updateCustomerGridCollection(Varien_Event_Observer $observer){
		try{
			$collection=$observer->getCollection();
			if(!isset($collection)){ // Check if is collectiom
				return $this;
			}
			if($collection instanceof Mage_Customer_Model_Resource_Customer_Collection){ // Check if is customer collection object
				$collection->joinAttribute('billing_company', 'customer_address/company', 'default_billing', null, 'left');
			}
			if(Mage::registry('company_filter_value')){
				$collection->addFieldToFilter('billing_company',array('like'=>"%".Mage::registry('company_filter_value')."%"));
			}			
		}
		catch(Exception $e){}
	}
	
	/*
	 * Purpose: Add company filter to collection
	 * Params: Mage_Customer_Model_Resource_Customer_Collection $collection,
	 *         Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * return: Magcoder_Customergrid_Model_Observer $this
	 * */
	public function companyFilterCallback($collection,$column){
		if(!$value=$column->getFilter()->getValue()){
			return $this;
		}
		if(!Mage::registry('company_filter_value')){
			Mage::register('company_filter_value',$value);
		}
	}
}
