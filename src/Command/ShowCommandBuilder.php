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
 * Show command builder.
 */
class ShowCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('show');
    }

    public function pretty($format = null)
    {
        $this->processBuilder->add('--pretty' . ($format ? '=' . $format : ''));
        return $this;
    }

    public function format($format)
    {
        $this->processBuilder->add('--format=' . $format);
        return $this;
    }

    public function abbrevCommit()
    {
        $this->processBuilder->add('--abbrev-commit');
        return $this;
    }

    public function noAbbrevCommit()
    {
        $this->processBuilder->add('--no-abbrev-commit');
        return $this;
    }

    public function oneline()
    {
        $this->processBuilder->add('--oneline');
        return $this;
    }

    public function encoding($encoding)
    {
        $this->processBuilder->add('--encoding=' . $encoding);
        return $this;
    }

    public function notes($ref = null)
    {
        $this->processBuilder->add('--notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    public function noNotes()
    {
        $this->processBuilder->add('--no-notes');
        return $this;
    }

    public function showNotes($ref = null)
    {
        $this->processBuilder->add('--show-notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    public function standardNotes()
    {
        $this->processBuilder->add('--standard-notes');
        return $this;
    }

    public function noStandardNotes()
    {
        $this->processBuilder->add('--no-standard-notes');
        return $this;
    }

    public function showSignature()
    {
        $this->processBuilder->add('--show-signature');
        return $this;
    }

    public function noPatch()
    {
        $this->processBuilder->add('--no-patch');
        return $this;
    }

    public function execute($object)
    {
        $this->processBuilder->add($object);
        return parent::run();
    }
}
