<?php
namespace Miles\Contact\Plugin\Controller\Index;

use Magento\Contact\Controller\Index\Post as CorePost;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Psr\Log\LoggerInterface;

class Post extends CorePost
{
    private $dataPersistor;

    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        parent::__construct($context, $contactsConfig, $mail, $dataPersistor, $logger);
        $this->dataPersistor = $dataPersistor;
    }

    public function afterExecute(\Magento\Contact\Controller\Index\Post $controller, $result)
    {
        if (!$this->getRequest()->isPost()) {
            return $result;
        }
        if ($this->dataPersistor->get('contact_us')) {
            return $result;
        }
        return $this->resultRedirectFactory->create()->setPath('thank-you');
    }
}
