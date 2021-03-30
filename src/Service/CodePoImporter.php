<?php

namespace App\Service;

use App\Service\ZipArchiveManager;

/**
 * Import Uk postcodes based on codepo report
 *
 * Class CodePoImporter
 */
class CodePoImporter
{
    /**
     * @var string TEMP_ARCHIVE_NAME
     */
    const TEMP_ARCHIVE_NAME = 'codepo_archive.zip';

    /**
     * @var ZipArchiveManager $zipManager
     */
    private $zipManager;

    /**
     * @var CodePoDataImporter $dataImporter
     */
    private $dataImporter;

    /**
     * @var string $codePoUrl
     */
    private $codePoUrl;

    /**
     * @var string $tempFolder
     */
    private $tempFolder;

    /**
     * CodePoImporter constructor.
     *
     * @param string $codePoUrl
     * @param string $tempFolder
     * @param ZipArchiveManager $zipManager
     */
    public function __construct(
        string $codePoUrl,
        string $tempFolder,
        ZipArchiveManager $zipManager,
        CodePoDataImporter $dataImporter
    ) {
        $this->zipManager   = $zipManager;
        $this->codePoUrl    = $codePoUrl;
        $this->tempFolder   = $tempFolder;
        $this->dataImporter = $dataImporter;
    }

    /**
     * Import Uk post code from specified source
     */
    public function import(): void
    {
        $zipFilePath = $this->downloadArchiveFile($this->codePoUrl, $this->tempFolder);

        $this->zipManager->init();
        $this->zipManager->openZipArchiveForRead($zipFilePath);

        $zipFiles = $this->zipManager->listFilesInArchive();

        foreach($zipFiles as $zipFile)
        {
            if($this->isValidImportFile($zipFile)) {
                $filePointer = $this->zipManager->getFileStream($zipFile);
                $this->dataImporter->csvFileDataImport($filePointer);
            }
        }

        $this->zipManager->closeZipArchive();
    }

    /**
     * Download archive file in temp folder
     *
     * @param string $codePoUrl
     * @param string $destFolder
     *
     * @return string
     */
    private function downloadArchiveFile(string $codePoUrl, string $destFolder): string
    {
        $destFilePath = $this->getDestinationFile($destFolder);

        if(!file_exists($destFilePath)) {
            mkdir(dirname($destFilePath), 0644, true);
            file_put_contents($destFilePath, file_get_contents($codePoUrl));
        }

        return $destFilePath;
    }

    /**
     * Get destination file for writing
     *
     * @param string $destFolder
     *
     * @return string
     */
    private function getDestinationFile(string $destFolder): string
    {
        $destFilePath = $destFolder . DIRECTORY_SEPARATOR . self::TEMP_ARCHIVE_NAME;

        return $destFilePath;
    }

    /**
     * Filter files by name and ext
     *
     * @param string $fileName
     *
     * @return bool
     */
    private function isValidImportFile(string $fileName): bool
    {
        $fileName = basename($fileName);

        return strlen($fileName) <= 6 && substr($fileName, -4) === '.csv';
    }
}