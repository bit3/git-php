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
 * @link       https://github.com/bit3/git-php
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Checkout command builder.
 */
class CheckoutCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('checkout');
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    /**
     * Add the ours option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function ours()
    {
        $this->processBuilder->add('--ours');
        return $this;
    }

    /**
     * Add the theirs option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function theirs()
    {
        $this->processBuilder->add('--theirs');
        return $this;
    }

    /**
     * Add the b option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function create()
    {
        $this->processBuilder->add('-b');
        return $this;
    }

    /**
     * Add the B option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function overwrite()
    {
        $this->processBuilder->add('-B');
        return $this;
    }

    /**
     * Add the track option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function track()
    {
        $this->processBuilder->add('--track');
        return $this;
    }

    /**
     * Add the no-track option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function noTrack()
    {
        $this->processBuilder->add('--no-track');
        return $this;
    }

    /**
     * Add the l option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function reflog()
    {
        $this->processBuilder->add('-l');
        return $this;
    }

    /**
     * Add the detach option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function detach()
    {
        $this->processBuilder->add('--detach');
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
        $this->processBuilder->add('--orphan');
        if ($newBranch) {
            $this->processBuilder->add($newBranch);
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
        $this->processBuilder->add('--ignore-skip-worktree-bits');
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function merge()
    {
        $this->processBuilder->add('--merge');
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
        $this->processBuilder->add('--conflict=' . $style);
        return $this;
    }

    /**
     * Add the patch option to the command line.
     *
     * @return CheckoutCommandBuilder
     */
    public function patch()
    {
        $this->processBuilder->add('--patch');
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
