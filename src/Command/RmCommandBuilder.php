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
 * Rm command builder.
 */
class RmCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('rm');
    }

    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    public function recursive()
    {
        $this->processBuilder->add('-r');
        return $this;
    }

    public function cached()
    {
        $this->processBuilder->add('--cached');
        return $this;
    }

    public function ignoreUnmatch()
    {
        $this->processBuilder->add('--ignore-unmatch');
        return $this;
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
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
