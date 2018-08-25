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
 * Checkout command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CheckoutCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'checkout';
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function force()
    {
        $this->arguments[] = '--force';
        return $this;
    }

    /**
     * Add the ours option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function ours()
    {
        $this->arguments[] = '--ours';
        return $this;
    }

    /**
     * Add the theirs option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function theirs()
    {
        $this->arguments[] = '--theirs';
        return $this;
    }

    /**
     * Add the b option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function create()
    {
        $this->arguments[] = '-b';
        return $this;
    }

    /**
     * Add the B option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function overwrite()
    {
        $this->arguments[] = '-B';
        return $this;
    }

    /**
     * Add the track option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function track()
    {
        $this->arguments[] = '--track';
        return $this;
    }

    /**
     * Add the no-track option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function noTrack()
    {
        $this->arguments[] = '--no-track';
        return $this;
    }

    /**
     * Add the l option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function reflog()
    {
        $this->arguments[] = '-l';
        return $this;
    }

    /**
     * Add the orphan option to the command line.
     *
     * @param null|string $newBranch The name of the new orphan branch.
     *
     * @return CheckoutCommandBuilder
     */
    public function orphan($newBranch = null)
    {
        $this->arguments[] = '--orphan';
        if ($newBranch) {
            $this->arguments[] = $newBranch;
        }
        return $this;
    }

    /**
     * Add the ignore-skip-worktree-bits option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function ignoreSkipWorktreeBits()
    {
        $this->arguments[] = '--ignore-skip-worktree-bits';
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function merge()
    {
        $this->arguments[] = '--merge';
        return $this;
    }

    /**
     * Add the conflict option to the command line.
     *
     * @param string $style The conflicht handler style.
     *
     * @return CheckoutCommandBuilder
     */
    public function conflict($style)
    {
        $this->arguments[] = '--conflict=' . $style;
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function patch()
    {
        $this->arguments[] = '--patch';
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
