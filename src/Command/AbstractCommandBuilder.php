<?php

/**
 * This file is part of the Contao Community Alliance Build System tools.
 *
 * @copyright 2014 Contao Community Alliance <https://c-c-a.org>
 * @author    Tristan Lins <t.lins@c-c-a.org>
 * @package   contao-community-alliance/build-system-repository-git
 * @license   MIT
 * @link      https://c-c-a.org
 */

namespace ContaoCommunityAlliance\BuildSystem\Repository\Command;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Abstract command builder.
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
	 * @var ProcessBuilder
	 */
	protected $processBuilder;

	/**
	 * The process output.
	 *
	 * @var null|string
	 */
	protected $output = null;

	public function __construct(GitRepository $repository)
	{
		$this->repository = $repository;

		$this->processBuilder = new ProcessBuilder();
		$this->processBuilder->add($this->repository->getConfig()->getGitExecutablePath());

		$this->initializeProcessBuilder();
	}

	protected function initializeProcessBuilder()
	{
	}

	/**
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
	 * @throws GitException
	 */
	public function execute()
	{
		if ($this->output !== null) {
			throw new GitException('Command cannot be executed twice');
		}
		$process = $this->processBuilder->getProcess();

		$this->repository->getConfig()->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();
		$this->output = trim($process->getOutput());

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not execute git command', $process);
		}

		return $this->output;
	}
}
