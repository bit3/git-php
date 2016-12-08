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
 * @copyright  2014 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Stash command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class StashCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('stash');
    }

    /**
     * Adds a message to StashCommandBuilder
     *
     * @param $message
     */
    public function message($message)
    {
        $this->processBuilder->add($message);
    }

    /**
     * List stashes and return the results
     *
     * @param string $options takes options applicable to the git log command
     *
     * @return mixed
     */
    public function listStash($options = null)
    {
        $this->processBuilder->add('list');
        if ($options) {
            $this->processBuilder->add($options);
        }
        return parent::run();
    }

    /**
     * Show the changes recorded in the stash as a diff
     * between the stashed state and its original parent.
     * When no $stash is given, shows the latest one.
     *
     * @param null $stash takes the stash number
     *
     * @return mixed
     */
    public function show($stash = null)
    {
        $this->processBuilder->add('show');
        if ($stash) {
            $this->processBuilder->add('stash@{' . $stash . '}');
        }
        return parent::run();

    }

    /**
     * Remove a single stashed state from the stash list.
     * When no $stash is given, it removes the latest one.
     *
     * @param null $stash takes the stash number
     *
     * @return mixed
     */
    public function drop($stash = null)
    {
        $this->processBuilder->add('show');
        if ($stash) {
            $this->processBuilder->add('stash@{' . $stash . '}');
        }
        return parent::run();
    }

    /**
     * Remove a single stashed state from the stash list
     * and apply it on top of the current working tree state.
     *
     * @param null $stash
     * @return mixed
     */
    public function pop($stash = null)
    {
        $this->processBuilder->add('pop');
        if ($stash) {
            $this->processBuilder->add('stash@{' . $stash . '}');
        }
        return parent::run();
    }

    /**
     * Like pop, but do not remove the state from the stash list.
     * Unlike pop, $stash may be any commit that looks like a commit
     * created by stash save or stash create.
     *
     * @param null $stash
     *
     * @return mixed
     */
    public function apply($stash = null)
    {
        $this->processBuilder->add('pop');
        if ($stash) {
            $this->processBuilder->add('stash@{' . $stash . '}');
        }
        return parent::run();
    }


    /**
     * Creates and checks out a new branch named $branchname starting from the commit at
     * which the $stash was originally created,
     * applies the changes recorded in $stash to the new working tree and index.
     *
     * @param $branchname
     *
     * @param null $stash
     *
     * @return mixed
     */
    public function branch($branchname, $stash = null)
    {
        $this->processBuilder->add('branch');
        $this->processBuilder->add($branchname);
        if ($stash) {
            $this->processBuilder->add('stash@{' . $stash . '}');
        }
        return parent::run();
    }


    /**
     * Remove all the stashed states.
     *
     * @return mixed
     */
    public function clear()
    {
        $this->processBuilder->add('clear');
        return parent::run();

    }


    /**
     * Save your local modifications to a new stash,
     * and run git reset --hard to revert them.
     * The <message> part is optional and gives
     * the description along with the stashed state.
     *
     * @param null $message
     *
     * @return mixed
     */
    public function save($message = null)
    {
        $this->processBuilder->add('branch');
        if ($message) {
            $this->processBuilder->add($message);
        }
        return parent::run();
    }

    /**
     * Create a stash (which is a regular commit object)
     * and return its object name,
     * without storing it anywhere in the ref namespace.
     *
     * @param null $message
     *
     * @return mixed
     */
    public function create($message = null)
    {
        $this->processBuilder->add('create');
        if ($message) {
            $this->processBuilder->add($message);
        }
        return parent::run();
    }

    /**
     * Store a given stash created via git stash create
     * (which is a dangling merge commit) in the stash ref,
     * updating the stash reflog.
     *
     * @param null $message
     *
     * @param null $commit
     *
     * @return mixed
     */
    public function store($message=null, $commit=null)
    {
        $this->processBuilder->add('store');
        if ($message) {
            $this->processBuilder->add('--message '.$message);
        }
        if ($commit) {
            $this->processBuilder->add($commit);
        }
        return parent::run();
    }
    /**
     * Execute the command and return the result.
     * to use with message function .
     *
     * @return mixed
     */
    public function execute()
    {
        return parent::run();
    }
}
