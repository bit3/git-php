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
 * @copyright  2014 Tristan Lins <tristan@lins.io>
 * @link       https://github.com/bit3/git-php
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @filesource
 */

namespace Bit3\GitPhp;

use Bit3\NoOpLogger\NoOpLogger;
use Psr\Log\LoggerInterface;

/**
 * Shareable configuration for git repositories.
 */
class GitConfig
{
    /**
     * The path to the git executable.
     *
     * @var string
     */
    protected $gitExecutablePath = 'git';

    /**
     * ID of the GPG certificate to sign commits.
     *
     * @var string|null
     */
    protected $signCommitUser = null;

    /**
     * ID of the GPG certificate to sign tags.
     *
     * @var string|null
     */
    protected $signTagUser = null;

    /**
     * Logger facility.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Create new git config.
     */
    function __construct()
    {
        $this->logger = new NoOpLogger();
    }

    /**
     * Set the git executable path.
     *
     * @param string $gitExecutablePath
     *
     * @return GitConfig
     */
    public function setGitExecutablePath($gitExecutablePath)
    {
        $this->gitExecutablePath = (string) $gitExecutablePath;
        return $this;
    }

    /**
     * Return the git executable path.
     *
     * @return string
     */
    public function getGitExecutablePath()
    {
        return $this->gitExecutablePath;
    }

    /**
     * Enable signing of commits.
     *
     * @param string $signUser The id of the GPG certificate.
     *
     * @return GitConfig
     */
    public function enableSignCommits($signUser)
    {
        $this->signCommitUser = (string) $signUser;
        return $this;
    }

    /**
     * Disable signing of commits.
     *
     * @return $this
     */
    public function disableSignCommits()
    {
        $this->signCommitUser = null;
        return $this;
    }

    /**
     * Determine if signing commits is enabled.
     *
     * @return boolean
     */
    public function isSignCommitsEnabled()
    {
        return (bool) $this->signCommitUser;
    }

    /**
     * Get the id of the GPG certificate to sign commits with.
     *
     * @return string|null
     */
    public function getSignCommitUser()
    {
        return $this->signCommitUser;
    }

    /**
     * Enable signing of tags.
     *
     * @param string $signUser The id of the GPG certificate.
     *
     * @return GitConfig
     */
    public function enableSignTags($signUser)
    {
        $this->signTagUser = (string) $signUser;
        return $this;
    }

    /**
     * Disable signing of tags.
     *
     * @return GitConfig
     */
    public function disableSignTags()
    {
        $this->signTagUser = null;
        return $this;
    }

    /**
     * Determine if signing tags is enabled.
     *
     * @return boolean
     */
    public function isSignTagsEnabled()
    {
        return (bool) $this->signTagUser;
    }

    /**
     * Get the id of the GPG certificate to sign tags with.
     *
     * @return string|null
     */
    public function getSignTagUser()
    {
        return $this->signTagUser;
    }

    /**
     * Set the logger facility.
     *
     * @param LoggerInterface $logger
     *
     * @return GitConfig
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Return the logger facility.
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
