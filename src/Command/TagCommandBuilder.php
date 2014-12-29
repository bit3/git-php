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
 * Tag command builder.
 */
class TagCommandBuilder extends AbstractCommandBuilder
{
    const CLEANUP_VERBATIM = 'verbatim';

    const CLEANUP_WHITESPACE = 'whitespace';

    const CLEANUP_STRIP = 'strip';

    protected $signIsset = false;

    protected $localUserIsset = false;

    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('tag');
    }

    public function annotate()
    {
        $this->processBuilder->add('--annotate');
        return $this;
    }

    public function sign()
    {
        $this->signIsset = true;
        $this->processBuilder->add('--sign');
        return $this;
    }

    public function localUser($keyid)
    {
        $this->localUserIsset = true;
        $this->processBuilder->add('--local-user=' . $keyid);
        return $this;
    }

    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    public function delete()
    {
        $this->processBuilder->add('--delete');
        return $this;
    }

    public function verify()
    {
        $this->processBuilder->add('--verify');
        return $this;
    }

    public function n($num)
    {
        $this->processBuilder->add('-n' . $num);
        return $this;
    }

    public function l($pattern)
    {
        $this->processBuilder->add('--list')->add($pattern);
        return $this;
    }

    public function column($options = null)
    {
        $this->processBuilder->add('--column' . ($options ? '=' . $options : ''));
        return $this;
    }

    public function noColumn()
    {
        $this->processBuilder->add('--no-column');
        return $this;
    }

    public function contains($commit)
    {
        $this->processBuilder->add('--contains')->add($commit);
        return $this;
    }

    public function pointsAt($object)
    {
        $this->processBuilder->add('--points-at')->add($object);
        return $this;
    }

    public function message($message)
    {
        $this->processBuilder->add('--message=' . $message);
        return $this;
    }

    public function file($file)
    {
        $this->processBuilder->add('--file=' . $file);
        return $this;
    }

    public function cleanup($mode)
    {
        $this->processBuilder->add('--cleanup=' . $mode);
        return $this;
    }

    public function execute($tagName, $commit = null)
    {
        if (!$this->signIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
            $this->sign()->localUser($this->repository->getConfig()->getSignCommitUser());
        } else {
            if ($this->signIsset && !$this->localUserIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
                $this->localUser($this->repository->getConfig()->getSignCommitUser());
            }
        }

        $this->processBuilder->add($tagName);

        if ($commit) {
            $this->processBuilder->add($commit);
        }

        return parent::run();
    }
}
