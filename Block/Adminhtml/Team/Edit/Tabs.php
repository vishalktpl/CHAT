<?php
namespace Dys\Team\Block\Adminhtml\Team\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('team_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Item Information'));
    }

     protected function _beforeToHtml()
    {
        $this->addTab(
            'form_section',
            [
                'label' => __('Team Info'),
                'title' => __('Team Info'),
                'content' => $this->getLayout()
                        ->createBlock('Dys\Team\Block\Adminhtml\Team\Edit\Tab\Main')
                        ->toHtml()
            ]
        );
        $this->addTab(
            'form_content',
            [
                'label' => __('Team Content'),
                'title' => __('Team Content'),
                'content' => $this->getLayout()
                        ->createBlock('Dys\Team\Block\Adminhtml\Team\Edit\Tab\Content')
                        ->toHtml()
            ]
        );
        return parent::_beforeToHtml();
    }

}
