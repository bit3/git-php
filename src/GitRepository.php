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

use ContaoCommunityAlliance\BuildSystem\Repository\Command\BranchCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\CheckoutCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\CloneCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\FetchCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\InitCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\PushCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\ResetCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\RevParseCommandBuilder;
use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * GIT repository adapter.
 */
class GitRepository
{
	/**
	 * The path to the git repository.
	 *
	 * @var string
	 */
	public $repositoryPath;

	/**
	 * The shared git configuration.
	 *
	 * @var GitConfig
	 */
	public $config;

	/**
	 * Create a new git repository.
	 *
	 * @param string    $repositoryPath
	 * @param GitConfig $config
	 */
	function __construct($repositoryPath, GitConfig $config = null)
	{
		$this->repositoryPath = (string) $repositoryPath;
		$this->config         = $config ? : new GitConfig();
	}

	/**
	 * Return the path to the git repository.
	 *
	 * @return string
	 */
	public function getRepositoryPath()
	{
		return $this->repositoryPath;
	}

	/**
	 * Return the shared git config.
	 *
	 * @return GitConfig
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * Determine if git is already initialized in the repository path.
	 *
	 * @return bool
	 */
	public function isInitialized()
	{
		return is_dir($this->repositoryPath . DIRECTORY_SEPARATOR . '.git');
	}

	/**
	 * Create an init command.
	 *
	 * @return InitCommandBuilder
	 */
	public function init()
	{
		return new InitCommandBuilder($this);
	}

	/**
	 * Create a clone command.
	 *
	 * @return CloneCommandBuilder
	 */
	public function cloneRepository()
	{
		return new CloneCommandBuilder($this);
	}

	/**
	 * Create a remote command.
	 *
	 * @return RemoteCommandBuilder
	 */
	public function remote()
	{
		return new RemoteCommandBuilder($this);
	}

	/**
	 * Create a branch command.
	 *
	 * @return BranchCommandBuilder
	 */
	public function branch()
	{
		return new BranchCommandBuilder($this);
	}

	/**
	 * Create a rev-parse command.
	 *
	 * @return RevParseCommandBuilder
	 */
	public function revParse()
	{
		return new RevParseCommandBuilder($this);
	}

	/**
	 * Create describe command.
	 *
	 * @return DescribeCommandBuilder
	 */
	public function describe()
	{
		return new DescribeCommandBuilder($this);
	}

	/**
	 * Create reset command.
	 *
	 * @return ResetCommandBuilder
	 */
	public function reset()
	{
		return new ResetCommandBuilder($this);
	}

	/**
	 * Create checkout command.
	 *
	 * @return CheckoutCommandBuilder
	 */
	public function checkout()
	{
		return new CheckoutCommandBuilder($this);
	}

	/**
	 * Create push command.
	 *
	 * @return PushCommandBuilder
	 */
	public function push()
	{
		return new PushCommandBuilder($this);
	}

	/**
	 * Create fetch command.
	 *
	 * @return FetchCommandBuilder
	 */
	public function fetch()
	{
		return new FetchCommandBuilder($this);
	}

	/**
	 * Get modification status.
	 *
	 * @return array An associative array, contains filename as keys and status arrays as values.
	 *               [
	 *                   'file/inside/the/repository.ext' => [
	 *                       'working' => 'M',
	 *                       'staging' => 'D',
	 *                   ]
	 *               ]
	 * @throws GitException
	 */
	public function status()
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('status')
			->add('-s');
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not determine modification status of repository', $process);
		}

		$files  = array();
		$status = explode("\n", $process->getOutput());

		foreach ($status as $line) {
			if (trim($line)) {
				$working = trim(substr($line, 0, 1));
				$staging = trim(substr($line, 1, 1));

				$stat = array(
					'working' => $working ? : false,
					'staging' => $staging ? : false,
				);

				$file = trim(substr($line, 2));

				$files[$file] = $stat;
			}
		}

		return $files;
	}

	/**
	 * Add a path to staging index.
	 *
	 * @param string $path
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function add($path)
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('add')
			->add($path);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not add file', $process);
		}

		return $this;
	}

	/**
	 * Remove a path from the repository.
	 *
	 * @param string $path
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function rm($path)
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('rm')
			->add($path);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not remove file', $process);
		}

		return $this;
	}

	/**
	 * Commit all staged changes.
	 *
	 * @param string $message
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function commit($message)
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('commit');
		if ($this->config->isSignCommitsEnabled()) {
			$processBuilder
				->add('--gpg-sign=' . $this->config->getSignCommitUser());
		}
		$processBuilder
			->add('-m')
			->add($message);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not commit changes', $process);
		}

		return $this;
	}

	/**
	 * Create a new tag.
	 *
	 * @param string      $tag     The tag name.
	 * @param string|bool $message The tag message.
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function tag($tag, $message = null)
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('tag');
		if ($this->config->isSignTagsEnabled()) {
			$processBuilder
				->add('-s')
				->add('-u')
				->add($this->config->getSignTagUser());
		}
		if ($message) {
			$processBuilder
				->add('-m')
				->add($message);
		}
		$processBuilder->add($tag);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not create tag', $process);
		}

		return $this;
	}
}
