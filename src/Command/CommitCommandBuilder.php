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

    protected $gpgSignIsset = false;

    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('commit');
    }

    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    public function reuseMessage($commit)
    {
        $this->processBuilder->add('--reuse-message=' . $commit);
        return $this;
    }

    public function fixup($commit)
    {
        $this->processBuilder->add('--fixup=' . $commit);
        return $this;
    }

    public function squash($commit)
    {
        $this->processBuilder->add('--squash=' . $commit);
        return $this;
    }

    public function resetAuthor()
    {
        $this->processBuilder->add('--reset-author');
        return $this;
    }

    public function short()
    {
        $this->processBuilder->add('--short');
        return $this;
    }

    public function branch()
    {
        $this->processBuilder->add('--branch');
        return $this;
    }

    public function porcelain()
    {
        $this->processBuilder->add('--porcelain');
        return $this;
    }

    public function long()
    {
        $this->processBuilder->add('--long');
        return $this;
    }

    public function null()
    {
        $this->processBuilder->add('--null');
        return $this;
    }

    public function file($file)
    {
        $this->processBuilder->add('--file=' . $file);
        return $this;
    }

    public function author($author)
    {
        $this->processBuilder->add('--author=' . $author);
        return $this;
    }

    public function date($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--date=' . $date);
        return $this;
    }

    public function message($message)
    {
        $this->processBuilder->add('--message=' . $message);
        return $this;
    }

    public function template($file)
    {
        $this->processBuilder->add('--template=' . $file);
        return $this;
    }

    public function signoff()
    {
        $this->processBuilder->add('--signoff');
        return $this;
    }

    public function noVerity()
    {
        $this->processBuilder->add('--no-verify');
        return $this;
    }

    public function allowEmpty()
    {
        $this->processBuilder->add('--allow-empty');
        return $this;
    }

    public function allowEmptyMessage()
    {
        $this->processBuilder->add('--allow-empty-message');
        return $this;
    }

    public function cleanup($mode)
    {
        $this->processBuilder->add('--cleanup=' . $mode);
        return $this;
    }

    public function amend()
    {
        $this->processBuilder->add('--amend');
        return $this;
    }

    public function noPostRewrite()
    {
        $this->processBuilder->add('--no-post-rewrite');
        return $this;
    }

    public function includ()
    {
        $this->processBuilder->add('--include');
        return $this;
    }

    public function only()
    {
        $this->processBuilder->add('--only');
        return $this;
    }

    public function untrackedFiles($mode = null)
    {
        $this->processBuilder->add('--untracked-files' . ($mode ? '=' . $mode : ''));
        return $this;
    }

    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    public function status()
    {
        $this->processBuilder->add('--status');
        return $this;
    }

    public function noStatus()
    {
        $this->processBuilder->add('--no-status');
        return $this;
    }

    public function gpgSign($keyid = null)
    {
        $this->gpgSignIsset = true;
        $this->processBuilder->add('--gpg-sign' . ($keyid ? '=' . $keyid : ''));
        return $this;
    }

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
