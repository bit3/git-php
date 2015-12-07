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
class AddCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('add');
    }

    /**
     * Add the dry run option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    /**
     * Add the update option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function update()
    {
        $this->processBuilder->add('--update');
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the no-all option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function noAll()
    {
        $this->processBuilder->add('--no-all');
        return $this;
    }

    /**
     * Add the intent-to-add option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function intentToAdd()
    {
        $this->processBuilder->add('--intent-to-add');
        return $this;
    }

    /**
     * Add the refresh option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function refresh()
    {
        $this->processBuilder->add('--refresh');
        return $this;
    }

    /**
     * Add the ignore-errors option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function ignoreErrors()
    {
        $this->processBuilder->add('--ignore-errors');
        return $this;
    }

    /**
     * Add the ignore-missing option to the command line.
     *
     * @return AddCommandBuilder
     */
    public function ignoreMissing()
    {
        $this->processBuilder->add('--ignore-missing');
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
