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

/**
 * Commit command builder.
 */
class CommitCommandBuilder extends AbstractCommandBuilder
{
    const CLEANUP_STRIP = 'strip';

    const CLEANUP_WHITESPACE = 'whitespace';

    const CLEANUP_VERBATIM = 'verbatim';

    const CLEANUP_DEFAULT = 'default';

    const UNTRACKED_FILES_NO = 'no';

    const UNTRACKED_FILES_NORMAL = 'normal';

    const UNTRACKED_FILES_ALL = 'all';

    /**
     * Flag determining if gpg signing is desired.
     *
     * @var bool
     */
    protected $gpgSignIsset = false;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('commit');
    }

    /**
     * Add the  option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    /**
     * Add the reuse-message option to the command line.
     *
     * @param string $commit The commit from which the message should be reused.
     *
     * @return CommitCommandBuilder
     */
    public function reuseMessage($commit)
    {
        $this->processBuilder->add('--reuse-message=' . $commit);
        return $this;
    }

    /**
     * Add the fixup option to the command line.
     *
     * @param string $commit The commit to fixup.
     *
     * @return CommitCommandBuilder
     */
    public function fixup($commit)
    {
        $this->processBuilder->add('--fixup=' . $commit);
        return $this;
    }

    /**
     * Add the squash option to the command line.
     *
     * @param string $commit The commit to squash.
     *
     * @return CommitCommandBuilder
     */
    public function squash($commit)
    {
        $this->processBuilder->add('--squash=' . $commit);
        return $this;
    }

    /**
     * Add the reset-author option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function resetAuthor()
    {
        $this->processBuilder->add('--reset-author');
        return $this;
    }

    /**
     * Add the short option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function short()
    {
        $this->processBuilder->add('--short');
        return $this;
    }

    /**
     * Add the branch option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function branch()
    {
        $this->processBuilder->add('--branch');
        return $this;
    }

    /**
     * Add the porcelain option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function porcelain()
    {
        $this->processBuilder->add('--porcelain');
        return $this;
    }

    /**
     * Add the long option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function long()
    {
        $this->processBuilder->add('--long');
        return $this;
    }

    /**
     * Add the null option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function null()
    {
        $this->processBuilder->add('--null');
        return $this;
    }

    /**
     * Add the file option to the command line.
     *
     * @param string $file The file.
     *
     * @return CommitCommandBuilder
     */
    public function file($file)
    {
        $this->processBuilder->add('--file=' . $file);
        return $this;
    }

    /**
     * Add the author option to the command line.
     *
     * @param string $author The author to use.
     *
     * @return CommitCommandBuilder
     */
    public function author($author)
    {
        $this->processBuilder->add('--author=' . $author);
        return $this;
    }

    /**
     * Add the date option to the command line.
     *
     * @param \DateTime|string $date The timestamp to use for the commit (if string: Y-m-d H:i:s).
     *
     * @return CommitCommandBuilder
     */
    public function date($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--date=' . $date);
        return $this;
    }

    /**
     * Add the message option to the command line.
     *
     * @param string $message The message to use.
     *
     * @return CommitCommandBuilder
     */
    public function message($message)
    {
        $this->processBuilder->add('--message=' . $message);
        return $this;
    }

    /**
     * Add the template option to the command line.
     *
     * @param string $file The template file.
     *
     * @return CommitCommandBuilder
     */
    public function template($file)
    {
        $this->processBuilder->add('--template=' . $file);
        return $this;
    }

    /**
     * Add the signoff option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function signoff()
    {
        $this->processBuilder->add('--signoff');
        return $this;
    }

    /**
     * Add the no-verify option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noVerity()
    {
        $this->processBuilder->add('--no-verify');
        return $this;
    }

    /**
     * Add the allow-empty option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function allowEmpty()
    {
        $this->processBuilder->add('--allow-empty');
        return $this;
    }

    /**
     * Add the allow-empty-message option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function allowEmptyMessage()
    {
        $this->processBuilder->add('--allow-empty-message');
        return $this;
    }

    /**
     * Add the cleanup option to the command line.
     *
     * @param string $mode The cleanup mode.
     *
     * @return CommitCommandBuilder
     */
    public function cleanup($mode)
    {
        $this->processBuilder->add('--cleanup=' . $mode);
        return $this;
    }

    /**
     * Add the amend option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function amend()
    {
        $this->processBuilder->add('--amend');
        return $this;
    }

    /**
     * Add the no-post-rewrite option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noPostRewrite()
    {
        $this->processBuilder->add('--no-post-rewrite');
        return $this;
    }

    /**
     * Add the include option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function includ()
    {
        $this->processBuilder->add('--include');
        return $this;
    }

    /**
     * Add the only option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function only()
    {
        $this->processBuilder->add('--only');
        return $this;
    }

    /**
     * Add the untracked-files option to the command line.
     *
     * @param null|string $mode How to handle untracked files.
     *
     * @return CommitCommandBuilder
     */
    public function untrackedFiles($mode = null)
    {
        $this->processBuilder->add('--untracked-files' . ($mode ? '=' . $mode : ''));
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the dry-run option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    /**
     * Add the status option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function status()
    {
        $this->processBuilder->add('--status');
        return $this;
    }

    /**
     * Add the no-status option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noStatus()
    {
        $this->processBuilder->add('--no-status');
        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @param null|string $keyId Optional id of the GPG key to use.
     *
     * @return CommitCommandBuilder
     */
    public function gpgSign($keyId = null)
    {
        $this->gpgSignIsset = true;
        $this->processBuilder->add('--gpg-sign' . ($keyId ? '=' . $keyId : ''));
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|       $pathspec Path to commit.
     *
     * @param null|string $_        More optional pathes to commit.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathspec = null, $_ = null)
    {
        // prevent launching the editor
        $this->processBuilder->add('--no-edit');

        if (!$this->gpgSignIsset && $this->repository->getConfig()->isSignCommitsEnabled()) {
            $this->gpgSign($this->repository->getConfig()->getSignCommitUser());
        }

        $args = func_get_args();
        if (count($args)) {
            $this->processBuilder->add('--');
            foreach ($args as $pathspec) {
                $this->processBuilder->add($pathspec);
            }
        }

        return parent::run();
    }
}
