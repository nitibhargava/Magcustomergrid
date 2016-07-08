<?php
Class Magcoder_Customergrid_Block_Adminhtml_Rendrer_Customercompany extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	/*
	 * Purpose: Get default billig address company
	 * Param: Varien_Object $row
	 * Return: string $company
	 * */
	public function render(Varien_Object $row){
		$company='';
		try{
			$data=array();
			$address=Mage::getModel('customer/customer')->load($row->getId())->getPrimaryBillingAddress();
			$isNewAddress=false;
			if(!$address){
				return $company;
			}
			$company=$address->getCompany();
		}
		catch(Exception $e){}
		return $company;
	}
}
