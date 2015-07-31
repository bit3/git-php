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
 * Describe command builder.
 */
class DescribeCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('describe');
    }

    /**
     * Add the dirty option to the command line.
     *
     * @param bool|string $mark The mark to use.
     *
     * @return DescribeCommandBuilder
     */
    public function dirty($mark = false)
    {
        $this->processBuilder->add('--dirty');
        if ($mark) {
            $this->processBuilder->add($mark);
        }
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function tags()
    {
        $this->processBuilder->add('--tags');
        return $this;
    }

    /**
     * Add the contains option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function contains()
    {
        $this->processBuilder->add('--contains');
        return $this;
    }

    /**
     * Add the abbrev option to the command line.
     *
     * @param int $n Chars after which to abbreviate.
     *
     * @return DescribeCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function abbrev($n)
    {
        $this->processBuilder->add('--abbrev=' . $n);
        return $this;
    }

    /**
     * Add the candidates option to the command line.
     *
     * @param int $n Amount of candidates.
     *
     * @return DescribeCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function candidates($n)
    {
        $this->processBuilder->add('--candidates=' . $n);
        return $this;
    }

    /**
     * Add the exact-match option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function exactMatch()
    {
        $this->processBuilder->add('--exact-match');
        return $this;
    }

    /**
     * Add the debug option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function debug()
    {
        $this->processBuilder->add('--debug');
        return $this;
    }

    /**
     * Add the long option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function long()
    {
        $this->processBuilder->add('--long');
        return $this;
    }

    /**
     * Add the match option to the command line.
     *
     * @param string $pattern The pattern to use for filtering.
     *
     * @return DescribeCommandBuilder
     */
    public function match($pattern)
    {
        $this->processBuilder->add('--match')->add($pattern);
        return $this;
    }

    /**
     * Add the always option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function always()
    {
        $this->processBuilder->add('--always');
        return $this;
    }

    /**
     * Add the first-parent option to the command line.
     *
     * @return DescribeCommandBuilder
     */
    public function firstParent()
    {
        $this->processBuilder->add('--first-parent');
        return $this;
    }

    /**
     * Execute the command and return the result.
     *
     * @param string $commit The commit to describe (defaults to HEAD).
     *
     * @return string
     */
    public function execute($commit = 'HEAD')
    {
        $this->processBuilder->add($commit);
        return parent::run();
    }
}
