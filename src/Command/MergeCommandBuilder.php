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
 * @author     Aaron Rubin <aaron@arkitech.net>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Merge command builder.
 */
class MergeCommandBuilder extends AbstractCommandBuilder
{
  /**
   * {@inheritDoc}
   */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'merge';
    }

  /**
   * Add the quiet option to the command line.
   *
   * @return MergeCommandBuilder
   */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

  /**
   * Add the strategy option to the command line with the given strategy.
   *
   * @param string $strategy Strategy to use when merging.
   *
   * @return MergeCommandBuilder
   */
    public function strategy($strategy)
    {
        $this->arguments[] = '--strategy='.$strategy;
        return $this;
    }

  /**
   * Build the command and execute it.
   *
   * @param null|string $branchOrTreeIsh Name of the branch or tree.
   *
   * @param null|       $path            Path to which check out.
   *
   * @param null|string $_               More optional arguments to append to the command.
   *
   * @return mixed
   *
   * @SuppressWarnings(PHPMD.ShortVariableName)
   * @SuppressWarnings(PHPMD.UnusedFormalParameter)
   * @SuppressWarnings(PHPMD.CamelCaseParameterName)
   */
    public function execute($branchOrTreeIsh = null, $path = null, $_ = null)
    {
        if ($branchOrTreeIsh) {
            $this->arguments[] = $branchOrTreeIsh;
        }

        $paths = \func_get_args();
        \array_shift($paths);
        if (\count($paths)) {
            $this->arguments[] = '--';
            foreach ($paths as $path) {
                $this->arguments[] = $path;
            }
        }

        return parent::run();
    }
}
