<?php

/**
 * This file is part of bit3/git-php.
 *
 * (c) Tristan Lins <tristan@lins.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    bit3/git-php
 * @author     Tristan Lins <tristan@lins.io>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

use Bit3\GitPhp\GitException;
use Bit3\GitPhp\GitRepository;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Process;

/**
 * Abstract command builder.
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
trait CommandBuilderTrait
{
    /**
     * The path to the git repository.
     *
     * @var GitRepository
     */
    public $repository;

    /**
     * The directory in their the process called.
     *
     * @var string
     */
    protected $workingDirectory;

    /**
     * The arguments for the command line process.
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The process output.
     *
     * @var null|string
     */
    protected $output;

    /**
     * Flag if we want to dry run.
     *
     * @var bool
     */
    protected $dryRun = false;

    /**
     * Constructor.
     *
     * @param GitRepository $repository The git repository to work on.
     */
    public function __construct(GitRepository $repository)
    {
        $this->repository       = $repository;
        $this->workingDirectory = $repository->getRepositoryPath();
        $this->arguments[]      = $this->repository->getConfig()->getGitExecutablePath();

        $this->initializeProcessBuilder();
    }

    /**
     * Enable dry run. If dry run is enabled, the execute() method return the executed command.
     *
     * @return $this
     */
    public function enableDryRun()
    {
        $this->dryRun = true;
        return $this;
    }

    /**
     * Initialize the process builder.
     *
     * @return void
     */
    abstract protected function initializeProcessBuilder();

    /**
     * Retrieve the output text.
     *
     * @return null|string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Build the the command line process.
     *
     * @return Process
     *
     * @throws LogicException In case no arguments have been provided.
     */
    protected function buildProcess()
    {
        if (!\count($this->arguments)) {
            throw new LogicException('You must add command arguments before the process can build.');
        }

        $process = new Process($this->arguments, $this->workingDirectory);

        $process->setCommandLine($process->getCommandLine());

        return $process;
    }

    /**
     * Execute the command.
     *
     * @return mixed Depend on the command.
     *
     * @throws GitException When the command is executed the second time or could not be executed.
     */
    protected function run()
    {
        $process = $this->buildProcess();

        if ($this->output !== null) {
            throw new GitException(
                'Command cannot be executed twice',
                $process->getWorkingDirectory(),
                $process->getCommandLine(),
                $this->output,
                ''
            );
        }

        $this->repository->getConfig()->getLogger()->debug(
            \sprintf('[ccabs-repository-git] exec [%s] %s', $this->workingDirectory, $process->getCommandLine())
        );

        if ($this->dryRun) {
            return $process->getCommandLine();
        }

        $process->run();
        $this->output = $process->getOutput();
        $this->output = \rtrim($this->output, "\r\n");

        if (!$process->isSuccessful()) {
            throw GitException::createFromProcess('Could not execute git command', $process);
        }

        return $this->output;
    }
}
