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
 * Rm command builder.
 */
class RmCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'rm';
    }

    /**
     * Add the force option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function force()
    {
        $this->arguments[] = '--force';
        return $this;
    }

    /**
     * Add the dry-run option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function dryRun()
    {
        $this->arguments[] = '--dry-run';
        return $this;
    }

    /**
     * Add the recursive option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function recursive()
    {
        $this->arguments[] = '-r';
        return $this;
    }

    /**
     * Add the cached option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function cached()
    {
        $this->arguments[] = '--cached';
        return $this;
    }

    /**
     * Add the ignore-unmatch option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function ignoreUnmatch()
    {
        $this->arguments[] = '--ignore-unmatch';
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return RmCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $pathspec Path spec.
     *
     * @param null|string $_        More optional path specs.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathspec = null, $_ = null)
    {
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
