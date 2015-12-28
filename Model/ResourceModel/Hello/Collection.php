<?php
namespace Ktpl\Hello\Model\ResourceModel\Hello;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\Hello\Model\Hello', 'Ktpl\Hello\Model\ResourceModel\Hello');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>