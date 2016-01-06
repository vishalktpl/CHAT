<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dys\Team\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * Show Contact Us page
     *
     * @return void
     */
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory)
    {
        $this->_objectManager = $objectManager;
        $this->_filesystem = $filesystem;        
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);    
    }

    public function execute()
    {
        $image = $this->getRequest()->getFiles();
        $post = $this->getRequest()->getPostValue();
        $currenttime = date('Y-m-d H:i:s');
        $model = $this->_objectManager->create('Dys\Team\Model\Team');
        $model->setData('title', $post['title']);
        $model->setData('content', $post['content']);
        $model->setData('is_active', $post['is_active']);
        $model->setData('publish_date', $currenttime);

        $path = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('team/');

            /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
            $uploader = $this->_fileUploaderFactory->create(['fileId' => $image['team_image']]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            //$uploader->setFilesDispersion(true); // Catalog structure
            $uploader->save($path);

        $fileName = $uploader->getUploadedFileName();
        if ($fileName) {
            $model->setData('team_image', 'team/'.$fileName);
        }

        $model->save();

        $this->messageManager->addSuccess(__('Team details have been inserted successfully.'));    
        $this->_redirect('*/*/viewlist');
    }
}
