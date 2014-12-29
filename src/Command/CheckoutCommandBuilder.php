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
 * Checkout command builder.
 */
class CheckoutCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('checkout');
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    public function ours()
    {
        $this->processBuilder->add('--ours');
        return $this;
    }

    public function theirs()
    {
        $this->processBuilder->add('--theirs');
        return $this;
    }

    public function create()
    {
        $this->processBuilder->add('-b');
        return $this;
    }

    public function overwrite()
    {
        $this->processBuilder->add('-B');
        return $this;
    }

    public function track()
    {
        $this->processBuilder->add('--track');
        return $this;
    }

    public function noTrack()
    {
        $this->processBuilder->add('--no-track');
        return $this;
    }

    public function reflog()
    {
        $this->processBuilder->add('-l');
        return $this;
    }

    public function detach()
    {
        $this->processBuilder->add('--detach');
        return $this;
    }

    public function orphan($newBranch = null)
    {
        $this->processBuilder->add('--orphan');
        if ($newBranch) {
            $this->processBuilder->add($newBranch);
        }
        return $this;
    }

    public function ignoreSkipWorktreeBits()
    {
        $this->processBuilder->add('--ignore-skip-worktree-bits');
        return $this;
    }

    public function merge()
    {
        $this->processBuilder->add('--merge');
        return $this;
    }

    public function conflict($style)
    {
        $this->processBuilder->add('--conflict=' . $style);
        return $this;
    }

    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    public function execute($branchOrTreeIsh = null, $path = null, $_ = null)
    {
        if ($branchOrTreeIsh) {
            $this->processBuilder->add($branchOrTreeIsh);
        }

        $paths = func_get_args();
        array_shift($paths);
        if (count($paths)) {
            $this->processBuilder->add('--');
            foreach ($paths as $path) {
                $this->processBuilder->add($path);
            }
        }

        return parent::run();
    }
}
