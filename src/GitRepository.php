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

use ContaoCommunityAlliance\BuildSystem\Repository\Command\AddCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\BranchCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\CheckoutCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\CloneCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\CommitCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\FetchCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\InitCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\LogCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\PushCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\ResetCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\RevParseCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\RmCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\ShowCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\StatusCommandBuilder;
use ContaoCommunityAlliance\BuildSystem\Repository\Command\TagCommandBuilder;
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
	 * Create status command.
	 *
	 * @return StatusCommandBuilder
	 */
	public function status()
	{
		return new StatusCommandBuilder($this);
	}

	/**
	 * Create add command.
	 *
	 * @return AddCommandBuilder
	 */
	public function add()
	{
		return new AddCommandBuilder($this);
	}

	/**
	 * Create rm command.
	 *
	 * @return RmCommandBuilder
	 */
	public function rm()
	{
		return new RmCommandBuilder($this);
	}

	/**
	 * Create commit command.
	 *
	 * @return CommitCommandBuilder
	 */
	public function commit()
	{
		return new CommitCommandBuilder($this);
	}

	/**
	 * Create tag command.
	 *
	 * @return TagCommandBuilder
	 */
	public function tag()
	{
		return new TagCommandBuilder($this);
	}

	/**
	 * Create show command.
	 *
	 * @return ShowCommandBuilder
	 */
	public function show()
	{
		return new ShowCommandBuilder($this);
	}

	/**
	 * Create log command.
	 *
	 * @return LogCommandBuilder
	 */
	public function log()
	{
		return new LogCommandBuilder($this);
	}
}
