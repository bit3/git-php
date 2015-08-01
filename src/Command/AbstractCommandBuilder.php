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
 * @copyright  2014 Tristan Lins <tristan@lins.io>
 * @link       https://github.com/bit3/git-php
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @filesource
 */

namespace Bit3\GitPhp\Command;

use Bit3\GitPhp\GitException;
use Bit3\GitPhp\GitRepository;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Abstract command builder.
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractCommandBuilder implements CommandBuilderInterface
{
    /**
     * The path to the git repository.
     *
     * @var GitRepository
     */
    public $repository;

    /**
     * The process builder in use.
     *
     * @var ProcessBuilder
     */
    protected $processBuilder;

    /**
     * The process output.
     *
     * @var null|string
     */
    protected $output = null;

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
        $this->repository = $repository;

        $this->processBuilder = new ProcessBuilder();
        $this->processBuilder->setWorkingDirectory($repository->getRepositoryPath());
        $this->processBuilder->add($this->repository->getConfig()->getGitExecutablePath());

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
    protected function initializeProcessBuilder()
    {
    }

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
     * Execute the command.
     *
     * @return mixed Depend on the command.
     *
     * @throws GitException When the command is executed the second time or could not be executed.
     */
    protected function run()
    {
        $process = $this->processBuilder->getProcess();

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
            sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
        );

        if ($this->dryRun) {
            return $process->getCommandLine();
        }

        $process->run();
        $this->output = $process->getOutput();
        $this->output = rtrim($this->output, "\r\n");

        if (!$process->isSuccessful()) {
            throw GitException::createFromProcess('Could not execute git command', $process);
        }

        return $this->output;
    }
}
