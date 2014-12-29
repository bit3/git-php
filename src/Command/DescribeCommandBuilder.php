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
 * Describe command builder.
 */
class DescribeCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('describe');
    }

    public function dirty($mark = false)
    {
        $this->processBuilder->add('--dirty');
        if ($mark) {
            $this->processBuilder->add($mark);
        }
        return $this;
    }

    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    public function tags()
    {
        $this->processBuilder->add('--tags');
        return $this;
    }

    public function contains()
    {
        $this->processBuilder->add('--contains');
        return $this;
    }

    public function abbrev($n)
    {
        $this->processBuilder->add('--abbrev=' . $n);
        return $this;
    }

    public function candidates($n)
    {
        $this->processBuilder->add('--candidates=' . $n);
        return $this;
    }

    public function exactMatch()
    {
        $this->processBuilder->add('--exact-match');
        return $this;
    }

    public function debug()
    {
        $this->processBuilder->add('--debug');
        return $this;
    }

    public function long()
    {
        $this->processBuilder->add('--long');
        return $this;
    }

    public function match($pattern)
    {
        $this->processBuilder->add('--match')->add($pattern);
        return $this;
    }

    public function always()
    {
        $this->processBuilder->add('--always');
        return $this;
    }

    public function firstParent()
    {
        $this->processBuilder->add('--first-parent');
        return $this;
    }

    public function execute($commit = 'HEAD')
    {
        $this->processBuilder->add($commit);
        return parent::run();
    }
}
