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
 * Show command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ShowCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('show');
    }

    /**
     * Add the  option to the command line.
     *
     * @param null|string $format The format.
     *
     * @return ShowCommandBuilder
     */
    public function pretty($format = null)
    {
        $this->processBuilder->add('--pretty' . ($format ? '=' . $format : ''));
        return $this;
    }

    /**
     * Add the format option to the command line.
     *
     * @param null|string $format The format.
     *
     * @return ShowCommandBuilder
     */
    public function format($format)
    {
        $this->processBuilder->add('--format=' . $format);
        return $this;
    }

    /**
     * Add the abbrev-commit option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function abbrevCommit()
    {
        $this->processBuilder->add('--abbrev-commit');
        return $this;
    }

    /**
     * Add the no-abbrev-commit option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function noAbbrevCommit()
    {
        $this->processBuilder->add('--no-abbrev-commit');
        return $this;
    }

    /**
     * Add the oneline option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function oneline()
    {
        $this->processBuilder->add('--oneline');
        return $this;
    }

    /**
     * Add the encoding option to the command line.
     *
     * @param string $encoding The encoding.
     *
     * @return ShowCommandBuilder
     */
    public function encoding($encoding)
    {
        $this->processBuilder->add('--encoding=' . $encoding);
        return $this;
    }

    /**
     * Add the notes option to the command line.
     *
     * @param null|string $ref The ref name.
     *
     * @return ShowCommandBuilder
     */
    public function notes($ref = null)
    {
        $this->processBuilder->add('--notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    /**
     * Add the no-notes option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function noNotes()
    {
        $this->processBuilder->add('--no-notes');
        return $this;
    }

    /**
     * Add the show-notes option to the command line.
     *
     * @param null|string $ref The ref name.
     *
     * @return ShowCommandBuilder
     */
    public function showNotes($ref = null)
    {
        $this->processBuilder->add('--show-notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    /**
     * Add the standard-notes option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function standardNotes()
    {
        $this->processBuilder->add('--standard-notes');
        return $this;
    }

    /**
     * Add the no-standard-notes option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function noStandardNotes()
    {
        $this->processBuilder->add('--no-standard-notes');
        return $this;
    }

    /**
     * Add the show-signature option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function showSignature()
    {
        $this->processBuilder->add('--show-signature');
        return $this;
    }

    /**
     * Add the no-patch option to the command line.
     *
     * @return ShowCommandBuilder
     */
    public function noPatch()
    {
        $this->processBuilder->add('--no-patch');
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string $object Name of the object to show.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($object)
    {
        $this->processBuilder->add($object);
        return parent::run();
    }
}
