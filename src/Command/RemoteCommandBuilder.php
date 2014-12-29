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
 * Remote command builder.
 */
class RemoteCommandBuilder extends AbstractCommandBuilder
{
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('remote');
    }

    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    public function add($name, $url)
    {
        $this->processBuilder->add('add')->add($name)->add($url);
        return $this;
    }

    public function rename($new, $old = null)
    {
        $this->processBuilder->add('rename');
        if ($old) {
            $this->processBuilder->add($old);
        }
        $this->processBuilder->add($new);
        return $this;
    }

    public function remove($name)
    {
        $this->processBuilder->add('remove')->add($name);
        return $this;
    }

    public function setHead($name, $branch)
    {
        $this->processBuilder->add('set-head')->add($name)->add($branch);
        return $this;
    }

    public function setHeadAuto($name)
    {
        $this->processBuilder->add('set-head')->add($name)->add('--auto');
        return $this;
    }

    public function setHeadDelete($name)
    {
        $this->processBuilder->add('set-head')->add($name)->add('--delete');
        return $this;
    }

    public function setBranches($name, $branch, $add = false)
    {
        $this->processBuilder->add('set-branches');
        if ($add) {
            $this->processBuilder->add('--add');
        }
        $this->processBuilder->add($name)->add($branch);
        return $this;
    }

    public function setUrl($name, $url, $oldUrl = null)
    {
        $this->processBuilder->add('set-url')->add($name)->add($url);
        if ($oldUrl) {
            $this->processBuilder->add($oldUrl);
        }
        return $this;
    }

    public function setPushUrl($name, $url, $oldUrl = null)
    {
        $this->processBuilder->add('set-url')->add($name)->add('--push')->add($url);
        if ($oldUrl) {
            $this->processBuilder->add($oldUrl);
        }
        return $this;
    }

    public function addUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--add')->add($name)->add($url);
        return $this;
    }

    public function addPushUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--add')->add('--push')->add($name)->add($url);
        return $this;
    }

    public function deleteUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--delete')->add($name)->add($url);
        return $this;
    }

    public function deletePushUrl($name, $url)
    {
        $this->processBuilder->add('set-url')->add('--delete')->add('--push')->add($name)->add($url);
        return $this;
    }

    public function show($name)
    {
        $this->processBuilder->add('show')->add($name);
        return $this;
    }

    public function prune($name, $dryRun = false)
    {
        $this->processBuilder->add('prune');
        if ($dryRun) {
            $this->processBuilder->add('--dry-run');
        }
        $this->processBuilder->add($name);
        return $this;
    }

    public function update($groupOrRemote, $prune = false)
    {
        $this->processBuilder->add('update');
        if ($prune) {
            $this->processBuilder->add('--prune');
        }
        $this->processBuilder->add($groupOrRemote);
        return $this;
    }

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
