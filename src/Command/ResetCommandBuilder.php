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
 * Reset command builder.
 */
class ResetCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('reset');
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    /**
     * Add the soft option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function soft()
    {
        $this->processBuilder->add('--soft');
        return $this;
    }

    /**
     * Add the mixed option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function mixed()
    {
        $this->processBuilder->add('--mixed');
        return $this;
    }

    /**
     * Add the hard option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function hard()
    {
        $this->processBuilder->add('--hard');
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function merge()
    {
        $this->processBuilder->add('--merge');
        return $this;
    }

    /**
     * Add the keep option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function keep()
    {
        $this->processBuilder->add('--keep');
        return $this;
    }

    /**
     * Add the commit to the command line.
     *
     * @param string $commit A commit hash.
     *
     * @return ResetCommandBuilder
     */
    public function commit($commit)
    {
        $this->processBuilder->add($commit);
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $path Path to reset.
     *
     * @param null|string $_    More optional pathes to reset.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($path = null, $_ = null)
    {
        $this->processBuilder->add('--');
        foreach (func_get_args() as $path) {
            $this->processBuilder->add($path);
        }
        return parent::run();
    }
}
