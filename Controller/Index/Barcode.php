<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/29/15
 * Time: 7:02 PM
 */
namespace Ktpl\Hello\Controller\Index;
use Magento\Framework\App\Action\Context;
class Barcode extends \Magento\Framework\App\Action\Action
{
    public $barCode;

    public function __construct(
        Context $context,
        \Zend_Barcode $barcode
    )
    {
        parent::__construct($context);
        $this->barCode=$barcode;
    }

    public function execute()
    {
        $barcodeOptions = array('text' => 'ZEND-FRAMEWORK');
        $rendererOptions = array('imageType' => 'png');
        header('Content-type: image/png');
        //$renderer  = imagepng($this->barCode->draw('code39', 'image', $barcodeOptions, $rendererOptions,true));
        $renderer  = imagepng($this->barCode->factory('code39', 'image', $barcodeOptions, $rendererOptions,true
        )->render());
        //echo $renderer;
        return;

    }
}
