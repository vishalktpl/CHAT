<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 10/29/15
 * Time: 7:02 PM
 */
namespace Ktpl\Hello\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;


class Post extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect('*/*/');
            return;
        }
        $model = $this->_objectManager->create('Ktpl\Hello\Model\Hello');
        $uploader = $this->_objectManager->create(
            'Magento\MediaStorage\Model\File\Uploader',
            ['fileId' => 'image']
        );
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);
        /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
        $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
            ->getDirectoryRead(DirectoryList::MEDIA);
        $result = $uploader->save($mediaDirectory->getAbsolutePath("ktpl/hello"));
        $post['image'] = $result['file'];
        $model->setData($post);
        try {

            $model->save();
            $this->messageManager->addSuccess(__('The item has been saved.'));
            $this->_redirect('*/*/hellolist/');
            //$this->_redirect('*/*/*/');
            return;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the item.'));
        }
        $this->_redirect('*/*/');
        return;

    }
}
