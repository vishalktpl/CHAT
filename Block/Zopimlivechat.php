<?php

namespace Dys\Zopimlivechat\Block;

class Zopimlivechat extends \Magento\Framework\View\Element\Template
{

	public function _prepareLayout()
	{
	    return parent::_prepareLayout();
	}

    public function isChatEnabled()
    {
        return $this->_scopeConfig->getValue(
            'zopimlivechat/zopimlivechat_options/allow_chat',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getChatEmbedd()
    {
        return $this->_scopeConfig->getValue(
            'zopimlivechat/zopimlivechat_options/chat_embedd',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}

?>