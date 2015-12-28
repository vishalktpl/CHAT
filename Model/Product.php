<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/2/15
 * Time: 7:14 PM
 */
namespace Ktpl\Hello\Model;

class Product extends \Magento\Catalog\Model\Product
{
    /*public $_product;

    public function __construct(
        Product $product
    )
    {
        $this->_product=$product;
        $this->_product->setName("My Hello ");
    }*/
    public function getName()
    {
        return "My Hello ".parent::getName();
    }

   /* public function getOldName()
    {
        return parent::getName();
    }*/

}