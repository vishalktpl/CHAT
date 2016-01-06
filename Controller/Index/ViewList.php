<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dys\Team\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dys\Team\Model\TeamFactory;

class ViewList extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();        
        $this->_view->getLayout()->getBlock('listing');
        $this->_view->renderLayout();
    }

}
