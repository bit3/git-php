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

namespace ContaoCommunityAlliance\BuildSystem\Repository;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Exception thrown when execution of git failed.
 */
class GitException extends \RuntimeException
{
	/**
	 * The working directory path.
	 *
	 * @var string
	 */
	protected $workingDirectory;

	/**
	 * The executed command line.
	 *
	 * @var string
	 */
	protected $commandLine;

	/**
	 * The git commands standard output.
	 *
	 * @var string
	 */
	protected $commandOutput;

	/**
	 * The git commands error output.
	 *
	 * @var string
	 */
	protected $errorOutput;

	/**
	 * Create a new git exception.
	 *
	 * @param string     $message
	 * @param int        $workingDirectory
	 * @param \Exception $commandLine
	 * @param string     $commandOutput
	 * @param string     $errorOutput
	 */
	public function __construct($message = "", $workingDirectory, $commandLine, $commandOutput, $errorOutput)
	{
		parent::__construct($message, 0, null);
		$this->workingDirectory = (string) $workingDirectory;
		$this->commandLine      = (string) $commandLine;
		$this->commandOutput    = (string) $commandOutput;
		$this->errorOutput      = (string) $errorOutput;
	}

	/**
	 * Return the working directory git was executed in.
	 *
	 * @return string
	 */
	public function getWorkingDirectory()
	{
		return $this->workingDirectory;
	}

	/**
	 * Return the command line to execute git.
	 *
	 * @return string
	 */
	public function getCommandLine()
	{
		return $this->commandLine;
	}

	/**
	 * Return the git commands standard output.
	 *
	 * @return string
	 */
	public function getCommandOutput()
	{
		return $this->commandOutput;
	}

	/**
	 * Return the git commands error output.
	 *
	 * @return string
	 */
	public function getErrorOutput()
	{
		return $this->errorOutput;
	}

	/**
	 * Create new exception from process.
	 *
	 * @param string  $message
	 * @param Process $process
	 *
	 * @return static
	 */
	static public function createFromProcess($message, Process $process)
	{
		return new static(
			$message,
			$process->getWorkingDirectory(),
			$process->getCommandLine(),
			$process->getOutput(),
			$process->getErrorOutput()
		);
	}
}
