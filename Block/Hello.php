<?php
namespace Ktpl\Hello\Block;
use Magento\Framework\Stdlib\CookieManagerInterface;

class Hello extends \Magento\Framework\View\Element\Template
{
    const LIMIT_NAME = 'limit';
    const PAGE_PARM_NAME = 'p';
    protected $_defaultToolbarBlock = 'Ktpl\Hello\Block\Hello\Toolbar';
    protected $_helloFactory;
    protected $_collection;
    protected $request;
    public function __construct(
        \Ktpl\Hello\Model\Hello $helloFactory,
        CookieManagerInterface $cookieManager,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->_helloFactory = $helloFactory;
        $this->cookieManager = $cookieManager;
        $this->request = $request;
        $this->setCollection($this->_helloFactory);
        parent::__construct($context,$data);
    }

    public function getImageUrl($imageBaseUrl)
    {
        if($imageBaseUrl)
        {
            return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."ktpl/hello".$imageBaseUrl;
        }
        return false;
    }

    public function getMainLimit()
    {

        $limit = (int) $this->request->getParam(self::LIMIT_NAME);
        return $limit ? $limit : 1;
    }

    public function getMyHelloData()
    {
        return "My Hello Data";

    }

    public function getCurrentPage()
    {
        $page = (int) $this->request->getParam(self::PAGE_PARM_NAME);
        return $page ? $page : 1;
    }


    public function setCollection($collection)
    {
        $this->_collection = $collection->getCollection();
        $this->_collection->setCurPage($this->getCurrentPage());

        // we need to set pagination only if passed value integer and more that 0
        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }


    }

    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('hello_list_toolbar_pager');
        if ($pagerBlock instanceof \Magento\Framework\Object) {
            /* @var $pagerBlock \Magento\Theme\Block\Html\Pager */
            $pagerBlock->setAvailableLimit($this->getAvailableLimit());

            $pagerBlock->setUseContainer(
                true
            )->setShowPerPage(
                    true
                )->setShowAmounts(
                    true
                )->setFrameLength(
                    $this->_scopeConfig->getValue(
                        'design/pagination/pagination_frame',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                    )
                )->setJump(
                    $this->_scopeConfig->getValue(
                        'design/pagination/pagination_frame_skip',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                    )
                )->setLimit(
                    $this->getLimit()
                )->setCollection(
                    $this->getCollection()
                );

            return $pagerBlock->toHtml();
        }

        return '';
    }

    public function getLimit()
    {
        $limit = $this->_getData('_current_limit');
        if ($limit) {
            return $limit;
        }

        $limits = $this->getAvailableLimit();
        $defaultLimit = $this->getDefaultPerPageValue();
        if (!$defaultLimit || !isset($limits[$defaultLimit])) {
            $keys = array_keys($limits);
            $defaultLimit = $keys[0];
        }

        $limit = $this->getMainLimit();
        if (!$limit || !isset($limits[$limit])) {
            $limit = $defaultLimit;
        }

        $this->setData('_current_limit', $limit);
        return $limit;
    }

    public function getDefaultPerPageValue()
    {
        return 5;
    }


    public function getAvailableLimit()
    {
        return array(5=>5,10=>10,20=>20,30=>30);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

}
