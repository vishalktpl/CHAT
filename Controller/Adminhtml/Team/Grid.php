<?php
namespace Dys\Team\Controller\Adminhtml\Team;

class Grid extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
