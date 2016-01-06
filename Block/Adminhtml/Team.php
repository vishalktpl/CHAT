<?php
namespace Dys\Team\Block\Adminhtml;

class Team extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @var string
     */
    //protected $_template = 'team/team.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    protected function _construct()
    {  
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Dys_Team';
        $this->_headerText = __('Manage Team');
        $this->_addButtonLabel = __('Add New Team');
        parent::_construct();
    }

}
