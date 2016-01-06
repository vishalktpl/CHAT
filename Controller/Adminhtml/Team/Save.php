<?php
namespace Dys\Team\Controller\Adminhtml\Team;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @param Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory)        
    {
        parent::__construct($context);
        $this->_filesystem = $filesystem;        
        $this->_fileUploaderFactory = $fileUploaderFactory;        
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $image = $this->getRequest()->getFiles();
        $data = $this->getRequest()->getPostValue();
        //echo '<pre>';print_r($_FILES);print_r($data);exit;

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Dys\Team\Model\Team');

            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);

            //delete image
            if(isset($data['team_image']['delete']) && $data['team_image']['delete'] != ''){
                unlink($mediaDirectory->getAbsolutePath().$data['team_image']['value']);
                $data['team_image'] = '';
            }

            if(isset($_FILES['team_image']['name']) && $_FILES['team_image']['name'] != '') {
                try {
                        $uploader = $this->_objectManager->create('Magento\MediaStorage\Model\File\Uploader',['fileId' => 'team_image']);
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                        $uploader->setAllowRenameFiles(true);
                        $result = $uploader->save($mediaDirectory->getAbsolutePath('team/'));
                       // echo $result['file'];exit;
                        unset($result['tmp_name']);
                        unset($result['path']);
                        $data['team_image'] = 'team/'.$result['file'];
                } catch (Exception $e) {
                    $data['team_image'] = $_FILES['team_image']['name'];
                }
            }
            else{
				if(isset($data['team_image']['value']))
					$data['team_image'] = $data['team_image']['value'];
            }

            //for store save..
            if(isset($data['stores'])) {
                if(in_array('0',$data['stores'])){
                    $data['store_id'] = '0';
                }
                else{
                    $data['store_id'] = implode(",", $data['stores']);
                }
               unset($data['stores']);
            }


            $id = $this->getRequest()->getParam('team_id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('The item has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['team_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the item.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['team_id' => $this->getRequest()->getParam('team_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
