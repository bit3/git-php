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

namespace Bit3\GitPhp;

use Bit3\GitPhp\Command\AddCommandBuilder;
use Bit3\GitPhp\Command\BranchCommandBuilder;
use Bit3\GitPhp\Command\CheckoutCommandBuilder;
use Bit3\GitPhp\Command\CloneCommandBuilder;
use Bit3\GitPhp\Command\CommitCommandBuilder;
use Bit3\GitPhp\Command\DescribeCommandBuilder;
use Bit3\GitPhp\Command\FetchCommandBuilder;
use Bit3\GitPhp\Command\InitCommandBuilder;
use Bit3\GitPhp\Command\LogCommandBuilder;
use Bit3\GitPhp\Command\LsRemoteCommandBuilder;
use Bit3\GitPhp\Command\PushCommandBuilder;
use Bit3\GitPhp\Command\RemoteCommandBuilder;
use Bit3\GitPhp\Command\ResetCommandBuilder;
use Bit3\GitPhp\Command\RevParseCommandBuilder;
use Bit3\GitPhp\Command\RmCommandBuilder;
use Bit3\GitPhp\Command\ShortLogCommandBuilder;
use Bit3\GitPhp\Command\ShowCommandBuilder;
use Bit3\GitPhp\Command\StatusCommandBuilder;
use Bit3\GitPhp\Command\TagCommandBuilder;

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
     * @param string    $repositoryPath The path to the git repository.
     *
     * @param GitConfig $config         The configuration to use.
     */
    public function __construct($repositoryPath, GitConfig $config = null)
    {
        $this->repositoryPath = (string) $repositoryPath;
        $this->config         = $config ?: new GitConfig();
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
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
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

    /**
     * Create shortlog command.
     *
     * @return ShortLogCommandBuilder
     */
    public function shortlog()
    {
        return new ShortLogCommandBuilder($this);
    }

    /**
     * Create ls-remote command.
     *
     * @return LsRemoteCommandBuilder
     */
    public function lsRemote()
    {
        return new LsRemoteCommandBuilder($this);
    }
}
