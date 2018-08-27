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
 * @author     Ahmad Marzouq <ahmad.marzouq@eagles-web.com>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
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
class StashCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'stash';
    }

    /**
     * Adds a message to StashCommandBuilder
     *
     * @param string $message The stash message.
     *
     * @return StashCommandBuilder
     */
    public function message($message)
    {
        $this->arguments[] = $message;
        return $this;
    }

    /**
     * List stashes and return the results
     *
     * @param string $options Takes options applicable to the git log command.
     *
     * @return mixed
     */
    public function listStash($options = null)
    {
        $this->arguments[] = 'list';
        if ($options) {
            $this->arguments[] = $options;
        }
        return $this->run();
    }

    /**
     * Show the changes recorded in the stash as a diff
     * between the stashed state and its original parent.
     * When no $stash is given, shows the latest one.
     *
     * @param int|null $stash Takes the stash number.
     *
     * @return mixed
     */
    public function show($stash = null)
    {
        $this->arguments[] = 'show';
        if ($stash) {
            $this->arguments[] = 'stash@{' . $stash . '}';
        }
        return $this->run();
    }

    /**
     * Remove a single stashed state from the stash list.
     * When no $stash is given, it removes the latest one.
     *
     * @param int|null $stash Takes the stash number.
     *
     * @return mixed
     */
    public function drop($stash = null)
    {
        $this->arguments[] = 'show';
        if ($stash) {
            $this->arguments[] = 'stash@{' . $stash . '}';
        }
        return $this->run();
    }

    /**
     * Remove a single stashed state from the stash list
     * and apply it on top of the current working tree state.
     *
     * @param int|null $stash Takes the stash number.
     *
     * @return mixed
     */
    public function pop($stash = null)
    {
        $this->arguments[] = 'pop';
        if ($stash) {
            $this->arguments[] = 'stash@{' . $stash . '}';
        }
        return $this->run();
    }

    /**
     * Like pop, but do not remove the state from the stash list.
     * Unlike pop, $stash may be any commit that looks like a commit
     * created by stash save or stash create.
     *
     * @param int|null $stash Takes the stash number.
     *
     * @return mixed
     */
    public function apply($stash = null)
    {
        $this->arguments[] = 'pop';
        if ($stash) {
            $this->arguments[] = 'stash@{' . $stash . '}';
        }
        return $this->run();
    }


    /**
     * Creates and checks out a new branch named $branchname starting from the commit at
     * which the $stash was originally created,
     * applies the changes recorded in $stash to the new working tree and index.
     *
     * @param string   $branchname The branch name.
     *
     * @param int|null $stash      Takes the stash number.
     *
     * @return mixed
     */
    public function branch($branchname, $stash = null)
    {
        $this->arguments[] = 'branch';
        $this->arguments[] = $branchname;
        if ($stash) {
            $this->arguments[] = 'stash@{' . $stash . '}';
        }
        return $this->run();
    }


    /**
     * Remove all the stashed states.
     *
     * @return mixed
     */
    public function clear()
    {
        $this->arguments[] = 'clear';
        return $this->run();
    }


    /**
     * Save your local modifications to a new stash,
     * and run git reset --hard to revert them.
     * The <message> part is optional and gives
     * the description along with the stashed state.
     *
     * @param string $message The stash message.
     *
     * @return mixed
     */
    public function save($message = null)
    {
        $this->arguments[] = 'branch';
        if ($message) {
            $this->arguments[] = $message;
        }
        return $this->run();
    }

    /**
     * Create a stash (which is a regular commit object)
     * and return its object name,
     * without storing it anywhere in the ref namespace.
     *
     * @param string $message The stash message.
     *
     * @return mixed
     */
    public function create($message = null)
    {
        $this->arguments[] = 'create';
        if ($message) {
            $this->arguments[] = $message;
        }
        return $this->run();
    }

    /**
     * Store a given stash created via git stash create
     * (which is a dangling merge commit) in the stash ref,
     * updating the stash reflog.
     *
     * @param string      $message The stash message.
     *
     * @param null|string $commit  The commit hash.
     *
     * @return mixed
     */
    public function store($message = null, $commit = null)
    {
        $this->arguments[] = 'store';
        if ($message) {
            $this->arguments[] = '--message '.$message;
        }
        if ($commit) {
            $this->arguments[] = $commit;
        }
        return $this->run();
    }
    /**
     * Execute the command and return the result.
     * to use with message function .
     *
     * @return mixed
     */
    public function execute()
    {
        return $this->run();
    }
}
