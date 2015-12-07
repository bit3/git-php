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
 * Branch command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class BranchCommandBuilder extends AbstractCommandBuilder
{
    const WHEN_ALWAYS = 'always';

    const WHEN_NEVER = 'never';

    const WHEN_AUTO = 'auto';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('branch');
    }

    /**
     * Add the D option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function delete()
    {
        $this->processBuilder->add('-D');
        return $this;
    }

    /**
     * Add the create-reflog option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function createReflog()
    {
        $this->processBuilder->add('--create-reflog');
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    /**
     * Add the M option to the command line.
     *
     * @param bool|string $oldName Optionally pass the old name.
     *
     * @return BranchCommandBuilder
     */
    public function move($oldName = false)
    {
        $this->processBuilder->add('-M');
        if ($oldName) {
            $this->processBuilder->add($oldName);
        }
        return $this;
    }

    /**
     * Add the color option to the command line.
     *
     * @param string $when When to use colors.
     *
     * @return BranchCommandBuilder
     *
     * @see BranchCommandBuilder::WHEN_ALWAYS
     * @see BranchCommandBuilder::WHEN_NEVER
     * @see BranchCommandBuilder::WHEN_AUTO.
     */
    public function color($when)
    {
        $this->processBuilder->add('--color=' . $when);
        return $this;
    }

    /**
     * Add the no-color option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function noColor()
    {
        $this->processBuilder->add('--no-color');
        return $this;
    }

    /**
     * Add the column option to the command line.
     *
     * @param bool|string $options Optional options to use.
     *
     * @return BranchCommandBuilder
     */
    public function column($options = false)
    {
        $this->processBuilder->add('--column' . ($options ? '=' . $options : ''));
        return $this;
    }

    /**
     * Add the no-column option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function noColumn()
    {
        $this->processBuilder->add('--no-column');
        return $this;
    }

    /**
     * Add the remotes option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function remotes()
    {
        $this->processBuilder->add('--remotes');
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the list option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function listBranches()
    {
        $this->processBuilder->add('--list');
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the abbrev option to the command line.
     *
     * @param int $length The length after which to cut.
     *
     * @return BranchCommandBuilder
     */
    public function abbrev($length)
    {
        $this->processBuilder->add('--abbrev=' . $length);
        return $this;
    }

    /**
     * Add the no-abbrev option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function noAbbrev()
    {
        $this->processBuilder->add('--no-abbrev');
        return $this;
    }

    /**
     * Add the track option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function track()
    {
        $this->processBuilder->add('--track');
        return $this;
    }

    /**
     * Add the no-track option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function noTrack()
    {
        $this->processBuilder->add('--no-track');
        return $this;
    }

    /**
     * Add the set-upstream option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function setUpstream()
    {
        $this->processBuilder->add('--set-upstream');
        return $this;
    }

    /**
     * Add the set-upstream-to option to the command line.
     *
     * @param string $upstream The upstream branch name.
     *
     * @return BranchCommandBuilder
     */
    public function setUpstreamTo($upstream)
    {
        $this->processBuilder->add('--set-upstream-to=' . $upstream);
        return $this;
    }

    /**
     * Add the unset-upstream option to the command line.
     *
     * @return BranchCommandBuilder
     */
    public function unsetUpstream()
    {
        $this->processBuilder->add('--unset-upstream');
        return $this;
    }

    /**
     * Add the contains option to the command line.
     *
     * @param string $commit The commit hash.
     *
     * @return BranchCommandBuilder
     */
    public function contains($commit)
    {
        $this->processBuilder->add('--contains')->add($commit);
        return $this;
    }

    /**
     * Add the merged option to the command line.
     *
     * @param string $commit The commit hash.
     *
     * @return BranchCommandBuilder
     */
    public function merged($commit)
    {
        $this->processBuilder->add('--merged')->add($commit);
        return $this;
    }

    /**
     * Add the no-merged option to the command line.
     *
     * @param string $commit The commit hash.
     *
     * @return BranchCommandBuilder
     */
    public function noMerged($commit)
    {
        $this->processBuilder->add('--no-merged')->add($commit);
        return $this;
    }

    /**
     * Execute the command and return the result.
     *
     * @param null|string $branchName Optionally the branch name on which to work on.
     *
     * @return string
     */
    public function execute($branchName = null)
    {
        if ($branchName) {
            $this->processBuilder->add($branchName);
        }
        return parent::run();
    }

    /**
     * Retrieve the branch names.
     *
     * @return string[]
     */
    public function getNames()
    {
        $branches = $this->execute();
        $branches = explode("\n", $branches);
        $branches = array_map(
            function ($branch) {
                return ltrim($branch, '*');
            },
            $branches
        );
        $branches = array_map('trim', $branches);
        $branches = array_filter($branches);

        return $branches;
    }
}
