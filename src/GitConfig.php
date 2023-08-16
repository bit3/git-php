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

namespace Bit3\GitPhp;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

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
    protected $signCommitUser;

    /**
     * ID of the GPG certificate to sign tags.
     *
     * @var string|null
     */
    protected $signTagUser;

    /**
     * Logger facility.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /** The author to use in git commits */
    private ?string $committerName = null;

    /** The author to use in git commits */
    private ?string $committerEMail = null;

    /**
     * Create new git config.
     */
    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    /**
     * Set the git executable path.
     *
     * @param string $gitExecutablePath Path to the git executable.
     *
     * @return GitConfig
     */
    public function setGitExecutablePath($gitExecutablePath)
    {
        /** @psalm-suppress RedundantCastGivenDocblockType - could be anything in theory - remove when type annotated */
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
        /** @psalm-suppress RedundantCastGivenDocblockType - could be anything in theory - remove when type annotated */
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
     * @return bool
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
        /** @psalm-suppress RedundantCastGivenDocblockType - could be anything in theory - remove when type annotated */
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
     * @param LoggerInterface $logger The logger to use.
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

    public function setCommitterName(string $committerName): self
    {
        $this->committerName = $committerName;

        return $this;
    }

    public function getCommitterName(): ?string
    {
        return $this->committerName;
    }

    public function setCommitterEMail(string $committerEMail): self
    {
        $this->committerEMail = $committerEMail;
        return $this;
    }

    public function getCommitterEMail(): ?string
    {
        return $this->committerEMail;
    }
}
