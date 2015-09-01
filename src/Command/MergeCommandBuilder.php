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
 * @author     Aaron Rubin <aaron@arkitech.net>
 * @copyright  2014 Tristan Lins <tristan@lins.io>
 * @link       https://github.com/bit3/git-php
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Checkout command builder.
 */
class MergeCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('merge');
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    public function strategy($strategy='') {
	    	$this->processBuilder->add("--strategy=$strategy");
				return $this;
    }

    public function execute($branchOrTreeIsh = null, $path = null, $_ = null)
    {
        if ($branchOrTreeIsh) {
            $this->processBuilder->add($branchOrTreeIsh);
        }

        $paths = func_get_args();
        array_shift($paths);
        if (count($paths)) {
            $this->processBuilder->add('--');
            foreach ($paths as $path) {
                $this->processBuilder->add($path);
            }
        }

        return parent::run();
    }
}
