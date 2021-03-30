<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\CodePoImporter;

class PostcodeImportCommand extends Command
{
    protected static $defaultName = 'postcode:import';
    protected static $defaultDescription = 'Import uk post codes in database from https://osdatahub.os.uk/';

    /**
     * @var CodePoImporter $codePoImporter
     */
    private $codePoImporter;

    /**
     * PostcodeImportCommand constructor.
     *
     * @param CodePoImporter $codePoImporter
     */
    public function __construct(CodePoImporter $codePoImporter)
    {
        parent::__construct();

        $this->codePoImporter = $codePoImporter;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);

        $io = new SymfonyStyle($input, $output);

        $io->write('<info>Start importing postcodes</info>');

        $this->codePoImporter->import();

        $io->success('Successful imported postcodes.');

        return 0;
    }
}
