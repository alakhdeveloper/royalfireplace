<?php

declare(strict_types=1);

namespace Miles\Amasty\ExportCore\Processing;

use Amasty\ExportCore\Api\Config\ProfileConfigInterface;
use Amasty\ExportCore\Model\Process\ProcessRepository;
use Amasty\ExportCore\Model\Process\ResourceModel\CollectionFactory;
use Amasty\ExportCore\Processing\JobManager as AmastyJobManager;
use Amasty\ExportCore\Processing\JobWatcher;
use Amasty\ExportCore\Processing\JobWatcherFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Shell;
use Symfony\Component\Process\PhpExecutableFinder;

class JobManager extends AmastyJobManager
{
    /**
     * @var CollectionFactory
     */
    private $processCollectionFactory;

    /**
     * @var JobWatcherFactory
     */
    private $jobWatcherFactory;

    /**
     * @var Shell
     */
    private $shell;

    /**
     * @var ProcessRepository
     */
    private $processRepository;

    /**
     * @var PhpExecutableFinder
     */
    private $phpExecutableFinder;

    public function __construct(
        CollectionFactory $processCollectionFactory,
        JobWatcherFactory $jobWatcherFactory,
        ProcessRepository $processRepository,
        PhpExecutableFinder $phpExecutableFinder,
        Shell $shell
    ) {
        $this->processCollectionFactory = $processCollectionFactory;
        $this->jobWatcherFactory = $jobWatcherFactory;
        $this->shell = $shell;
        $this->processRepository = $processRepository;
        $this->phpExecutableFinder = $phpExecutableFinder;
        parent::__construct($processCollectionFactory, $jobWatcherFactory, $processRepository, $phpExecutableFinder, $shell);
    }
    
    public function requestJob(ProfileConfigInterface $profileConfig, string $identity = null): JobWatcher
    {
        try {
            $matchingProcess = $this->processRepository->getByIdentity($identity);

            if ($matchingProcess->getPid() && $this->isPidAlive((int)$matchingProcess->getPid())) {
                return $this->jobWatcherFactory->create([
                    'processIdentity' => $identity
                ]);
            } else {
                $this->processRepository->delete($matchingProcess);
            }
        } catch (NoSuchEntityException $e) {
            ;// Nothiiiiiing
        }

        $identity = $this->processRepository->initiateProcess($profileConfig, $identity);

        $phpPath = 'php';

        $this->shell->execute(
            $phpPath . ' %s amasty:export:run-job %s > /dev/null &',
            [
                BP . '/bin/magento',
                $identity
            ]
        );

        return $this->jobWatcherFactory->create(['processIdentity' => $identity]);
    }
}
