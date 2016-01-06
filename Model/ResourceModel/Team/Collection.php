<?php
namespace Dys\Team\Model\ResourceModel\Team;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dys\Team\Model\Team', 'Dys\Team\Model\ResourceModel\Team');
        $this->_map['fields']['team_id'] = 'main_table.team_id';
    }

    public function addStoreFilter($store, $withAdmin = true){

        if  ($store instanceof \Magento\Store\Model\Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        $this->addFilter('store_id', array('in' => $store));

        return $this;
    }

}
