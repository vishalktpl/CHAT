<?php
namespace Ktpl\Hello\Model\ResourceModel;

class Hello extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('hello', 'hello_id');
    }
}
?>