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
 * Add command builder.
 */
class AddCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('add');
    }

    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    public function patch()
    {
        $this->processBuilder->add('--patch');
        return $this;
    }

    public function update()
    {
        $this->processBuilder->add('--update');
        return $this;
    }

    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    public function noAll()
    {
        $this->processBuilder->add('--no-all');
        return $this;
    }

    public function intentToAdd()
    {
        $this->processBuilder->add('--intent-to-add');
        return $this;
    }

    public function refresh()
    {
        $this->processBuilder->add('--refresh');
        return $this;
    }

    public function ignoreErrors()
    {
        $this->processBuilder->add('--ignore-errors');
        return $this;
    }

    public function ignoreMissing()
    {
        $this->processBuilder->add('--ignore-missing');
        return $this;
    }

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
