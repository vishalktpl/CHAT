<?php
namespace Ktpl\Hello\Model;

class Hello extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\Hello\Model\ResourceModel\Hello');
    }
}
?>