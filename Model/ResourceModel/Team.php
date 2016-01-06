<?php
namespace Dys\Team\Model\ResourceModel;

class Team extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('team', 'team_id');
    }
}
?>