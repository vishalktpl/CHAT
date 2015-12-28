<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/29/15
 * Time: 5:31 PM
 */
namespace Ktpl\Hello\Block;

class Form extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context,$data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getHelloAction()
    {
        return $this->getUrl('hello/index/post');
    }
}