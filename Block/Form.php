<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dys\Team\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\Store;

class Form extends Template
{
    const PAGE_VAR_NAME = 'np';

    protected $_coreRegistry = null;
    protected $_collectionFactory;
    protected $_productCollectionFactory;
    protected $_imageHelper;
    protected $catalogProductVisibility;
    protected $_configurable;
    protected $_productFactory;
    //for getting parent id of simple
    protected $_catalogProductTypeConfigurable;
    protected $_resource;
    protected $_connection;


    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        //for getting parent id of simple
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $catalogProductTypeConfigurable,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $collectionFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_coreRegistry = $registry;
        $this->_imageHelper = $context->getImageHelper();        
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->_productFactory = $productFactory;        
        $this->_configurable=$configurable;
		$this->_productCollectionFactory = $productCollectionFactory;
           //for getting parent id of simple
        $this->_catalogProductTypeConfigurable = $catalogProductTypeConfigurable;
          $this->_resource = $resource;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    protected function _getConnection()
    {
        if (null === $this->_connection) {
            $this->_connection = $this->_resource->getConnection();
        }
        return $this->_connection;
    }

    public function getBestSellerData()
    {        
       //$collection = $this->_collectionFactory->create()->setModel('Magento\Catalog\Model\Product');
       //return $collection;
        $connection = $this->_getConnection();
        $table = $this->_resource->getTableName('sales_bestsellers_aggregated_daily'); 
        $select = 'SELECT  `product_name` ,  `product_id` ,  `store_id` , SUM(`qty_ordered`) as qty FROM  '.$table.' 
                            WHERE  `store_id` = 1 GROUP BY  `product_name`  ORDER BY  qty DESC limit 8';
        $bestselling = $connection->fetchAll($select);
        return $bestselling;
        //echo '<pre>';print_r($bestselling);exit;
    }

    public function getProducts()
	{
		$collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*')->addAttributeToFilter('erin_recommends','1');  
		return $collection;
	}


    public function getProductData($id){
        
        /*
        $product = $this->_productFactory->create();
        $product->setStoreId($this->getRequest()->getParam('store', Store::DEFAULT_STORE_ID));
        $product->load(67); 
        $associated_products = $this->_configurable->getUsedProductCollection($product)
                                ->addAttributeToSelect('*')
                                ->addFilterByRequiredOptions();
        foreach ($associated_products as  $value) {            
        }
        //load product info by id...
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $product = $objectManager->create('Magento\Catalog\Model\Product')->load($id);
        echo $product->getName();
        */
        //echo '<pre>';print_r($product); exit;
       

        $parentByChild = $this->_catalogProductTypeConfigurable->getParentIdsByChild($id);
        if(isset($parentByChild[0])){
            //set id as parent product id...
            $id = $parentByChild[0];          
        }

        $collection = $this->_productCollectionFactory->create()
                        ->addAttributeToSelect(array('image','name','final_price','price','url_key','small_image','thumbnail'))
                        ->addAttributeToFilter('entity_id',$id);
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        return $collection;
		
    }     
}
