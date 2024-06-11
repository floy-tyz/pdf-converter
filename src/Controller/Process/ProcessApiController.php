<?php

namespace App\Controller\Process;

use App\Bus\EventBusInterface;
use App\Entity\Process;
use App\Service\Process\Enum\ProcessStatusEnum;
use App\Service\Process\Event\SaveCombinedFileEvent;
use App\Service\Process\Event\SaveProcessedFilesEvent;
use App\Service\File\Interface\FileRepositoryInterface;
use App\Traits\ResponseStatusTrait;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcessApiController extends AbstractController
{
    use ResponseStatusTrait;

    public function __construct(
        private readonly EventBusInterface $eventBus,
        private readonly FileRepositoryInterface $fileRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    #[Route('/api/v1/process/{uuid}/files', name: 'api.process.save.files', methods: ["POST"])]
    public function saveProcessedFiles(Request $request, ?Process $process): Response
    {
        if (!$process) {
            throw new EntityNotFoundException();
        }

        if ($process->getStatus() === ProcessStatusEnum::STATUS_PROCESSED->value) {
            return $this->success();
        }

        /** @var array<UploadedFile> $files */
        $files = $request->files->all();

        $this->logger->critical("MESSAGES COUNT " . count($files));
        $this->logger->critical("MESSAGES DESTINATION " . serialize($files));

        $this->eventBus->publish(new SaveProcessedFilesEvent($process, $request->files->all()));

        return $this->success();
    }
}
