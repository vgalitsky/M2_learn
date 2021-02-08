<?php
 
namespace Vg\Learn\Model\Vendor;
 
use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class LogoUploader
{
    const IMAGE_TMP_PATH = 'vg/learn/vendor/tmp/logo';
    const IMAGE_PATH = 'vg/learn/vendor/logo';
    
    protected $coreFileStorageDatabase;
    protected $mediaDirectory;
    protected $uploaderFactory;
    protected $storeManager;
    protected $logger;
    protected $baseTmpPath;
    protected $basePath;
    protected $allowedExtensions;
    protected $allowedMimeTypes;
 
    /**
     * ImageUploader constructor
     *
     * @param Database $coreFileStorageDatabase
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param string $baseTmpPath
     * @param string $basePath
     * @param string[] $allowedExtensions
     * @param string[] $allowedMimeTypes
     * @throws FileSystemException
     */
    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $baseTmpPath = self::IMAGE_TMP_PATH,
        $basePath = self::IMAGE_PATH,
        $allowedExtensions = [],
        $allowedMimeTypes = []
    ) {
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->baseTmpPath = $baseTmpPath;
        $this->basePath = $basePath;
        $this->allowedExtensions = $allowedExtensions;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }
 
    /**
     * @param type $baseTmpPath
     */
    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }
 
    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }
 
    /**
     * 
     * @param string $allowedExtensions
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }
 
    /**
     * @return string
     */
    public function getBaseTmpPath()
    {
        return $this->baseTmpPath;
    }
 
    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }
 
    /**
     * 
     * @return type
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }
 
    /**
     * 
     * @param type $path
     * @param type $imageName
     * @return type
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }
 
    /**
     * 
     * @param type $imageName
     * @return type
     * @throws LocalizedException
     */
    public function moveFileFromTmp($imageName)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();
        $baseImagePath = $this->getFilePath(
            $basePath,
            Uploader::getNewFileName(
                $this->mediaDirectory->getAbsolutePath(
                    $this->getFilePath($basePath, $imageName)
                )
            )
        );
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);
 
        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (Exception $e) {
            throw new LocalizedException(
                __('Error while saving the file(s).')
            );
        }
 
        return $imageName;
    }
 
    /**
     * LocalizedException
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();
 
        /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        if (!$uploader->checkMimeType($this->allowedMimeTypes)) {
            throw new LocalizedException(__('Logo validation failed.'));
        }
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));
        unset($result['path']);
 
        if (!$result) {
            throw new LocalizedException(
                __('Logo can not be saved to the destination folder.')
            );
        }
 
        
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];
 
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Error while saving the file(s).')
                );
            }
        }
 
        return $result;
    }
}