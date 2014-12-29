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
 * Reset command builder.
 */
class ResetCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('reset');
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    public function soft()
    {
        $this->processBuilder->add('--soft');
        return $this;
    }

    public function mixed()
    {
        $this->processBuilder->add('--mixed');
        return $this;
    }

    public function hard()
    {
        $this->processBuilder->add('--hard');
        return $this;
    }

    public function merge()
    {
        $this->processBuilder->add('--merge');
        return $this;
    }

    public function keep()
    {
        $this->processBuilder->add('--keep');
        return $this;
    }

    public function commit($commit)
    {
        $this->processBuilder->add($commit);
        return $this;
    }

    public function execute($path = null, $_ = null)
    {
        $this->processBuilder->add('--');
        foreach (func_get_args() as $path) {
            $this->processBuilder->add($path);
        }
        return parent::run();
    }
}
