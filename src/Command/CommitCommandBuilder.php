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
 * @copyright  2014-2022 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Commit command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CommitCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    public const CLEANUP_STRIP = 'strip';

    public const CLEANUP_WHITESPACE = 'whitespace';

    public const CLEANUP_VERBATIM = 'verbatim';

    public const CLEANUP_DEFAULT = 'default';

    public const UNTRACKED_FILES_NO = 'no';

    public const UNTRACKED_FILES_NORMAL = 'normal';

    public const UNTRACKED_FILES_ALL = 'all';

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
        $this->arguments[] = 'commit';
    }

    /**
     * Add the  option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function all()
    {
        $this->arguments[] = '--all';
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function patch()
    {
        $this->arguments[] = '--patch';
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
        $this->arguments[] = '--reuse-message=' . $commit;
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
        $this->arguments[] = '--fixup=' . $commit;
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
        $this->arguments[] = '--squash=' . $commit;
        return $this;
    }

    /**
     * Add the reset-author option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function resetAuthor()
    {
        $this->arguments[] = '--reset-author';
        return $this;
    }

    /**
     * Add the short option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function short()
    {
        $this->arguments[] = '--short';
        return $this;
    }

    /**
     * Add the branch option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function branch()
    {
        $this->arguments[] = '--branch';
        return $this;
    }

    /**
     * Add the porcelain option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function porcelain()
    {
        $this->arguments[] = '--porcelain';
        return $this;
    }

    /**
     * Add the long option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function long()
    {
        $this->arguments[] = '--long';
        return $this;
    }

    /**
     * Add the null option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function null()
    {
        $this->arguments[] = '--null';
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
        $this->arguments[] = '--file=' . $file;
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
        $this->arguments[] = '--author=' . $author;
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
        $this->arguments[] = '--date=' . $date;
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
        $this->arguments[] = '--message=' . $message;
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
        $this->arguments[] = '--template=' . $file;
        return $this;
    }

    /**
     * Add the signoff option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function signoff()
    {
        $this->arguments[] = '--signoff';
        return $this;
    }

    /**
     * Add the no-verify option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noVerity()
    {
        $this->arguments[] = '--no-verify';
        return $this;
    }

    /**
     * Add the allow-empty option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function allowEmpty()
    {
        $this->arguments[] = '--allow-empty';
        return $this;
    }

    /**
     * Add the allow-empty-message option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function allowEmptyMessage()
    {
        $this->arguments[] = '--allow-empty-message';
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
        $this->arguments[] = '--cleanup=' . $mode;
        return $this;
    }

    /**
     * Add the amend option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function amend()
    {
        $this->arguments[] = '--amend';
        return $this;
    }

    /**
     * Add the no-post-rewrite option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noPostRewrite()
    {
        $this->arguments[] = '--no-post-rewrite';
        return $this;
    }

    /**
     * Add the include option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function includ()
    {
        $this->arguments[] = '--include';
        return $this;
    }

    /**
     * Add the only option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function only()
    {
        $this->arguments[] = '--only';
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
        $this->arguments[] = '--untracked-files' . ($mode ? '=' . $mode : '');
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function verbose()
    {
        $this->arguments[] = '--verbose';
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the dry-run option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function dryRun()
    {
        $this->arguments[] = '--dry-run';
        return $this;
    }

    /**
     * Add the status option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function status()
    {
        $this->arguments[] = '--status';
        return $this;
    }

    /**
     * Add the no-status option to the command line.
     *
     * @return CommitCommandBuilder
     */
    public function noStatus()
    {
        $this->arguments[] = '--no-status';
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
        $this->arguments[]  = '--gpg-sign' . ($keyId ? '=' . $keyId : '');
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null        $pathspec Path to commit.
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
        $this->arguments[] = '--no-edit';

        if (!$this->gpgSignIsset && $this->repository->getConfig()->isSignCommitsEnabled()) {
            $this->gpgSign($this->repository->getConfig()->getSignCommitUser());
        }

        $args = \func_get_args();
        if (\count($args)) {
            $this->arguments[] = '--';
            foreach ($args as $pathspec) {
                $this->arguments[] = $pathspec;
            }
        }

        return $this->run();
    }
}
