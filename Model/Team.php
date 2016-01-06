<?php
namespace Dys\Team\Model;

class Team extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dys\Team\Model\ResourceModel\Team');
    }
}
?>