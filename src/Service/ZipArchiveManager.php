<?php

namespace App\Service;

use \ZipArchive;

/**
 * Manage zip archives - open, extract files, close
 * Class ZipArchive
 *
 * @package App\Service
 */
class ZipArchiveManager
{
    /**
     * @var ZipArchive $zipArchive
     */
    private $zipArchive;

    /**
     * ZipArchive constructor.
     */
    public function init()
    {
        $this->zipArchive = new ZipArchive();
    }

    /**
     * @param string $path
     */
    public function openZipArchiveForRead(string $path): void
    {
        $this->isInitialised();

        $this->zipArchive->open($path);
    }

    /**
     * @return array
     */
    public function listFilesInArchive(): array
    {
        $this->isInitialised();

        $files = [];

        for($i = 0; $i < $this->zipArchive->numFiles; $i++)
        {
            $file = $this->zipArchive->statIndex($i);

            $files[] = $file['name'];
        }

        return $files;
    }

    /**
     * @throws \Exception
     *
     * @param string $fileName
     *
     * @return boolean|resource
     */
    public function getFileStream(string $fileName)
    {
        $this->isInitialised();

        return $this->zipArchive->getStream($fileName);
    }

    /**
     * @return void
     */
    public function closeZipArchive(): void
    {
        $this->zipArchive->close();
    }

    /**
     * Throw am exception when zip archive is not initialised
     *
     * @throws \Exception
     */
    private function isInitialised()
    {
        if(!$this->zipArchive)
        {
            throw new \Exception('Zip archive is not initialised. Class init method first');
        }
    }
}
