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
 * Remote command builder.
 */
class RemoteCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('remote');
    }

    /**
     * Add the  option to the command line.
     *
     * @return RemoteCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the add option to the command line.
     *
     * @param string $name Name of the new remote to add.
     *
     * @param string $url  URL to the new remote.
     *
     * @return RemoteCommandBuilder
     */
    public function add($name, $url)
    {
        $this->processBuilder->add('add')->add($name)->add($url);
        return $this;
    }

    /**
     * Add the rename option to the command line.
     *
     * @param string      $new The new name.
     *
     * @param null|string $old The old name.
     *
     * @return RemoteCommandBuilder
     */
    public function rename($new, $old = null)
    {
        $this->processBuilder->add('rename');
        if ($old) {
            $this->processBuilder->add($old);
        }
        $this->processBuilder->add($new);
        return $this;
    }

    /**
     * Add the remove option to the command line.
     *
     * @param string $name The name of the remote to remove.
     *
     * @return RemoteCommandBuilder
     */
    public function remove($name)
    {
        $this->processBuilder->add('remove')->add($name);
        return $this;
    }

    /**
     * Add the set-head option to the command line.
     *
     * @param string $name   The name of the head.
     *
     * @param string $branch The name of the branch.
     *
     * @return RemoteCommandBuilder
     */
    public function setHead($name, $branch)
    {
        $this->processBuilder->add('set-head')->add($name)->add($branch);
        return $this;
    }

    /**
     * Add the set-head option to the command line.
     *
     * @param string $name The name of the head.
     *
     * @return RemoteCommandBuilder
     */
    public function setHeadAuto($name)
    {
        $this->processBuilder->add('set-head')->add($name)->add('--auto');
        return $this;
    }

    /**
     * Add the set-head option to the command line.
     *
     * @param string $name The name of the head.
     *
     * @return RemoteCommandBuilder
     */
    public function setHeadDelete($name)
    {
        $this->processBuilder->add('set-head')->add($name)->add('--delete');
        return $this;
    }

    /**
     * Add the set-branches option to the command line.
     *
     * @param string $name   Name of the remote.
     *
     * @param string $branch Name of the branch.
     *
     * @param bool   $add    Flag if the name should be added.
     *
     * @return RemoteCommandBuilder
     */
    public function setBranches($name, $branch, $add = false)
    {
        $this->processBuilder->add('set-branches');
        if ($add) {
            $this->processBuilder->add('--add');
        }
        $this->processBuilder->add($name)->add($branch);
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string      $name   Name of the remote.
     *
     * @param string      $url    The URL.
     *
     * @param null|string $oldUrl The old URL.
     *
     * @return RemoteCommandBuilder
     */
    public function setUrl($name, $url, $oldUrl = null)
    {
        $this->processBuilder->add('set-url')->add($name)->add($url);
        if ($oldUrl) {
            $this->processBuilder->add($oldUrl);
        }
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string      $name   Name of the remote.
     *
     * @param string      $url    The URL.
     *
     * @param null|string $oldUrl The old URL.
     *
     * @return RemoteCommandBuilder
     */
    public function setPushUrl($name, $url, $oldUrl = null)
    {
        $this->processBuilder->add('set-url')->add($name)->add('--push')->add($url);
        if ($oldUrl) {
            $this->processBuilder->add($oldUrl);
        }
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string $name Name of the remote.
     *
     * @param string $url  The URL.
     *
     * @return RemoteCommandBuilder
     */
    public function addUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--add')->add($name)->add($url);
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string $name Name of the remote.
     *
     * @param string $url  The URL.
     *
     * @return RemoteCommandBuilder
     */
    public function addPushUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--add')->add('--push')->add($name)->add($url);
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string $name Name of the remote.
     *
     * @param string $url  The URL.
     *
     * @return RemoteCommandBuilder
     */
    public function deleteUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--delete')->add($name)->add($url);
        return $this;
    }

    /**
     * Add the set-url option to the command line.
     *
     * @param string $name Name of the remote.
     *
     * @param string $url  The URL.
     *
     * @return RemoteCommandBuilder
     */
    public function deletePushUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--delete')->add('--push')->add($name)->add($url);
        return $this;
    }

    /**
     * Add the show option to the command line.
     *
     * @param string $name Name of the remote.
     *
     * @return RemoteCommandBuilder
     */
    public function show($name)
    {
        $this->processBuilder->add('show')->add($name);
        return $this;
    }

    /**
     * Add the prune option to the command line.
     *
     * @param string $name   Name of the remote.
     *
     * @param bool   $dryRun Flag if a dry run shall be done.
     *
     * @return RemoteCommandBuilder
     */
    public function prune($name, $dryRun = false)
    {
        $this->processBuilder->add('prune');
        if ($dryRun) {
            $this->processBuilder->add('--dry-run');
        }
        $this->processBuilder->add($name);
        return $this;
    }

    /**
     * Add the update option to the command line.
     *
     * @param string $groupOrRemote Name of the remote or a remote group.
     *
     * @param bool   $prune         Flag if the remote shall be pruned.
     *
     * @return RemoteCommandBuilder
     */
    public function update($groupOrRemote, $prune = false)
    {
        $this->processBuilder->add('update');
        if ($prune) {
            $this->processBuilder->add('--prune');
        }
        $this->processBuilder->add($groupOrRemote);
        return $this;
    }

    /**
     * Execute the command and return the output.
     *
     * @return string
     */
    public function execute()
    {
        return $this->run();
    }

    /**
     * Return a list of remote names.
     *
     * @return array
     */
    public function getNames()
    {
        $remotes = $this->execute();
        $remotes = explode("\n", $remotes);
        $remotes = array_map('trim', $remotes);
        $remotes = array_filter($remotes);

        return $remotes;
    }
}
