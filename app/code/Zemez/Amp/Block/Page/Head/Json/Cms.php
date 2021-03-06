<?php
namespace Zemez\Amp\Block\Page\Head\Json;
use Magento\Store\Model\ScopeInterface;

class Cms extends \Magento\Framework\View\Element\Template
{
    const NULL_PAGE_TITLE = "Magento Cms Page";
    const NULL_PAGE_CONTENT_HEADING = "Page Content Heading";
    const NULL_PAGE_DESCRIPTION = "Default Description";
    const LOGO_IMAGE_WIDTH = 272;
    const LOGO_IMAGE_HEIGHT = 90;

    /**
     * @var Magento\Cms\Model\Page
     */
    protected $_cmsPage;

    public $_storeManager;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Cms\Model\Page $cmsPage,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Page $cmsPage,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_cmsPage = $cmsPage;
        $this->_deploymentConfig = $deploymentConfig;
        $this->_storeManager = $storeManager;
        $this->_date = $date;
    }

    /**
     * Retrieve string by JSON format according to http://schema.org requirements
     * @return string
     */
    public function getJson()
    {

        $cmsPage = $this->_cmsPage;

//        $logoBlock = $this->getLayout()->getBlock(' logo');
//        $logo = $logoBlock ? $logoBlock->getLogoSrc() : '';
//
//        if ($cmsPage->getTitle()) {
//            $pageTitle = $cmsPage->getTitle();
//        } elseif($this->pageConfig->getTitle()->get()) {
//            $pageTitle = $this->pageConfig->getTitle()->get();
//        } else {
//            $pageTitle = self::NULL_PAGE_TITLE;
//        }
//        $pageCreatedAt = $cmsPage->getCreationTime() ? $cmsPage->getCreationTime() : '';
//        if (!$pageCreatedAt) {
//            $date = $this->_deploymentConfig->get('install/date');
//            $pageCreatedAt = date('c', strtotime($date));
//        }
//        $pageUpdatedAt = $cmsPage->getUpdateTime() ? $cmsPage->getUpdateTime() : '';
//        if (!$pageUpdatedAt) {
//            $date = $this->_date->gmtDate('Y-m') . '-01';
//            $pageUpdatedAt = date('c', strtotime($date));
//        }
//        $pageDescription = $this->pageConfig->getDescription() ? mb_substr($this->pageConfig->getDescription(), 0, 250, 'UTF-8') : self::NULL_PAGE_DESCRIPTION;
//
//        if ($cmsPage->getContentHeading()) {
//            $pageContentHeading = $cmsPage->getContentHeading();
//        } elseif($this->pageConfig->getTitle()->get()) {
//            $pageContentHeading = $this->pageConfig->getTitle()->get();
//        } else {
//            $pageContentHeading = self::NULL_PAGE_CONTENT_HEADING;
//        }

        $json = [
            "@context" => "http://schema.org",
            "@type" => "Organization",
            "name" => $cmsPage->getTitle(),
            "url" => $this->_storeManager->getStore()->getBaseUrl()
        ];

        return str_replace('\/', '/', json_encode($json));
    }

}