<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 11/7/15
 * Time: 2:35 PM
 */
namespace Ktpl\Hello\Helper;
use Magento\Framework\App\Helper\AbstractHelper;

class Image extends AbstractHelper
{

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Product\ImageFactory $productImageFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo
    ) {
        $this->_productImageFactory = $productImageFactory;
        parent::__construct($context);
        $this->_assetRepo = $assetRepo;
    }


}