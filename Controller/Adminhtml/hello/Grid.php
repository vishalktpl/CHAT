<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/10/15
 * Time: 4:25 PM
 */

namespace Ktpl\Hello\Controller\Adminhtml\hello;

class Grid extends \Magento\Backend\App\Action//Ktpl\Hello\Controller\Adminhtml\hello\Index
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }



    /**
     * Slider grid action
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->resultPageFactory->create();
        return $resultLayout;
    }
}
