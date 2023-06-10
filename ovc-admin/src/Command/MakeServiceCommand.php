<?php

namespace App\Command;

use App\Validator\Command as AppAssert;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'make:service',
    description: 'Creates a service with passed argument',
)]
class MakeServiceCommand extends Command
{
    protected static string $fileDirectory;
    protected static string $projectDir;

    #[AppAssert\ServiceCommand]
    private ?string $name = null;

    public function __construct(
        private readonly KernelInterface $kernel,
    ) {
        parent::__construct(null);

        self::$projectDir = $this->kernel->getProjectDir();
        self::$fileDirectory = sprintf('%s%s', static::$projectDir, '/src/Service');
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the service')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->name = (string) $input->getArgument('name');

        $file = $this->createFile($input, $this->name);

        if (false === $file) {
            $io->error(sprintf('Could not create a Service. File and/or directory %s', static::$fileDirectory));

            return Command::FAILURE;
        }

        $io->success("Service {$this->name} created");

        return Command::SUCCESS;
    }

    /**
     * @throws FileException - if could not create a file
     */
    private function createFile(InputInterface $input, string $filename): bool
    {
        $className = (string) $input->getArgument('name');
        $pathDir = self::$fileDirectory."/$filename.php";

        try {
            file_put_contents($pathDir, <<<EOF
                <?php

                namespace App\Service;

                class $className {
                    // code ..
                }
                EOF
                , FILE_APPEND);
        } catch (FileException $fileEx) {
            throw new FileException("Could not create a file: {$fileEx->getMessage()} at {$fileEx->getTraceAsString()}");
        }

        return true;
    }
}
