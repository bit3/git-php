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
 * Add command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class AddCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'add';
    }

    /**
     * Add the dry run option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function dryRun()
    {
        $this->arguments[] = '--dry-run';
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function verbose()
    {
        $this->arguments[] = '--verbose';
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function force()
    {
        $this->arguments[] = '--force';
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function patch()
    {
        $this->arguments[] = '--patch';
        return $this;
    }

    /**
     * Add the update option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function update()
    {
        $this->arguments[] = '--update';
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function all()
    {
        $this->arguments[] = '--all';
        return $this;
    }

    /**
     * Add the no-all option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function noAll()
    {
        $this->arguments[] = '--no-all';
        return $this;
    }

    /**
     * Add the intent-to-add option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function intentToAdd()
    {
        $this->arguments[] = '--intent-to-add';
        return $this;
    }

    /**
     * Add the refresh option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function refresh()
    {
        $this->arguments[] = '--refresh';
        return $this;
    }

    /**
     * Add the ignore-errors option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function ignoreErrors()
    {
        $this->arguments[] = '--ignore-errors';
        return $this;
    }

    /**
     * Add the ignore-missing option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function ignoreMissing()
    {
        $this->arguments[] = '--ignore-missing';
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $pathspec Optional path spec to add to the command line.
     *
     * @param null|string $_        More arguments to append to the command.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathspec = null, $_ = null)
    {
        /** @var list<string> $args */
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
