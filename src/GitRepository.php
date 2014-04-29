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
	 * Initialize new git repository.
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function init()
	{
		if (!is_dir($this->repositoryPath)) {
			mkdir($this->repositoryPath, 0777, true);
		}

		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('init');
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not init repository', $process);
		}

		return $this;
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
	 * Set the push url of a remote.
	 *
	 * @param string $repositoryUrl
	 * @param string $remote
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function remoteSetPushUrl($repositoryUrl, $remote = 'origin')
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('remote')
			->add('set-url')
			->add('--push')
			->add($remote)
			->add($repositoryUrl);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not set remote push url of repository', $process);
		}

		return $this;
	}

	/**
	 * Add a new remote.
	 *
	 * @param string $repositoryUrl
	 * @param string $remote
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function remoteAdd($repositoryUrl, $remote = 'origin')
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('remote')
			->add('add')
			->add($remote)
			->add($repositoryUrl);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not add remote to repository', $process);
		}

		return $this;
	}

	/**
	 * Download objects and refs from another repository.
	 *
	 * @param string $remote
	 *
	 * @return bool
	 * @throws GitException
	 */
	public function remoteFetch($prune = false, $remote = 'origin')
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('fetch');
		if ($prune) {
			$processBuilder->add('--prune');
		}
		$processBuilder
			->add($remote);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not fetch from remote of repository', $process);
		}

		return $this;
	}

	/**
	 * Checkout a branch.
	 *
	 * @param $ref
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function checkout($ref, $force = false)
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('checkout');
		if ($force) {
			$processBuilder
				->add('-f');
		}
		$processBuilder
			->add($ref);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not checkout branch', $process);
		}

		return $this;
	}

	/**
	 * Push a reference to another repository.
	 *
	 * @param string $ref
	 *
	 * @return $this
	 * @throws GitException
	 */
	public function push($ref, $remote = 'origin')
	{
		$processBuilder = new ProcessBuilder();
		$processBuilder
			->setWorkingDirectory($this->repositoryPath)
			->add($this->config->getGitExecutablePath())
			->add('push')
			->add($remote)
			->add($ref);
		$process = $processBuilder->getProcess();

		$this->config->getLogger()->debug(
			sprintf('[ccabs-repository-git] exec [%s] %s', $process->getWorkingDirectory(), $process->getCommandLine())
		);

		$process->run();

		if (!$process->isSuccessful()) {
			throw GitException::createFromProcess('Could not push branch', $process);
		}

		return $this;
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
