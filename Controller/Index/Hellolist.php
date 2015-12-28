<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/29/15
 * Time: 2:45 PM
 */
namespace Ktpl\Hello\Controller\Index;

class Hellolist extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
