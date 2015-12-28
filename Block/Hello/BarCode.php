<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/28/15
 * Time: 3:04 PM
 */
namespace Ktpl\Hello\Block\Hello;

class BarCode extends \Magento\Framework\View\Element\Template
{
    public $barCode;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Zend_Barcode $barcode,
        array $data = []
    )
    {
        $this->barCode=$barcode;
        parent::__construct($context,$data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    protected function _toHtml()
    {
        $html = $this->getBarcodeImage();
        return $html;
    }

    public function getBarcodeImage()
    {
        $barcodeOptions = array('text' => 'ZEND-FRAMEWORK');
        $rendererOptions = array('imageType' => 'png');
        header('Content-type: image/png');
        $renderer  = imagepng($this->barCode->factory('code39', 'image', $barcodeOptions, $rendererOptions,true
        )->render());

        return $renderer;

    }
}
