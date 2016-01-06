<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dys\Team\Block;

use Magento\Framework\View\Element\Template;

/**
 * Main contact form block
 */
class Listing extends Template
{
    /**
     * @param Template\Context $context
     * @param array $data
     */
    protected $_teamFactory; 
    protected $_customerFactory; 

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,        
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Dys\Team\Model\TeamFactory $teamFactory,
        array $data = []
     ) 
    {  	  
	    $this->_teamFactory = $teamFactory;
        $this->customerFactory = $customerFactory;   
        parent::__construct($context, $data);
        $customer  = $this->customerFactory->create()->getCollection()->addFieldToFilter('entity_id',2);
        //echo '<pre>';print_r($customer->getData());exit;  
        //get collection of data 
        $collection = $this->_teamFactory->create()->getCollection();
        $this->setCollection($collection);
        $this->pageConfig->getTitle()->set(__('Team List'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            // create pager block for collection 
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'dys.team.record.pager'
            );
            // // assign collection to pager
            $pager->setLimit(4)->setCollection($this->getCollection());
            $this->setChild('pager', $pager);// set pager block in layout
        }
        return $this;
    }
  
    /**
     * @return string
     */
    // method for get pager html
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    } 
}
