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

namespace Bit3\GitPhp\Command;

/**
 * Reset command builder.
 */
class ResetCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'reset';
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function patch()
    {
        $this->arguments[] = '--patch';
        return $this;
    }

    /**
     * Add the soft option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function soft()
    {
        $this->arguments[] = '--soft';
        return $this;
    }

    /**
     * Add the mixed option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function mixed()
    {
        $this->arguments[] = '--mixed';
        return $this;
    }

    /**
     * Add the hard option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function hard()
    {
        $this->arguments[] = '--hard';
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function merge()
    {
        $this->arguments[] = '--merge';
        return $this;
    }

    /**
     * Add the keep option to the command line.
     *
     * @return ResetCommandBuilder
     */
    public function keep()
    {
        $this->arguments[] = '--keep';
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
        $this->arguments[] = $commit;
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
        /** @var list<string> $args */
        $args = \func_get_args();
        if (\count($args)) {
            $this->arguments[] = '--';
            foreach ($args as $pathSpec) {
                $this->arguments[] = $pathSpec;
            }
        }

        return (string) $this->run();
    }
}
