<?php
namespace Dys\Team\Block\Adminhtml;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Dys\Team\Model\teamFactory
     */
    protected $_teamFactory;

    /**
     * @var \Dys\Team\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dys\Team\Model\teamFactory $teamFactory
     * @param \Dys\Team\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(        
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dys\Team\Model\TeamFactory $teamFactory,
        \Dys\Team\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_teamFactory = $teamFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
	//echo 'adminhtml/grid/testse';exit;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('team_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_teamFactory->create()->getCollection();
        $this->setCollection($collection);
        //echo '<pre>';print_r($collection->getData());exit;
        return parent::_prepareCollection();
        //return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'team_id',
            [
                'header' => __('ID'),
                'type' => 'number',
               // 'filter_index' => 'rt.team_id',
                'index' => 'team_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'team_image',
                [
                    'header' => __('Image'),
                    'index' => 'team_image',
                    'renderer' =>  '\Dys\Team\Block\Adminhtml\Team\Grid\Image',
                    'class' => 'xxx'
                ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'filter_index' => 'title',
                'class' => 'xxx'
            ]
        );

        $this->addColumn(
            'publish_date',
            [
                'header' => __('Publish Date'),
                'type' => 'datetime',
                'filter_index' => 'publish_date',
                'index' => 'publish_date',
            ]
        );

         /**
         * Check is single store mode
         */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'store_id',
                ['header' => __('Store'), 'index' => 'store_id', 'type' => 'store', 'store_view' => true]
            );
        }

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => $this->_status->getOptionArray()
            ]
        );


        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit'
                        ],
                        'field' => 'team_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('team_id');
        $this->setMassactionIdFilter('rt.team_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('teams');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('team/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();
        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'update_status',
            [
                'label' => __('Update Status'),
                'url' => $this->getUrl('team/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );
    }
    

    /**
     * @return string
     */
    public function getGridUrl()
    {
        //echo 'test';exit;
        return $this->getUrl('team/team/grid', ['_current' => true]);
    }

    /**
     * @param \Dys\Team\Model\team|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            'team/team/edit',
            ['team_id' => $row->getId()]
        );
    }
}
