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
 * Init command builder.
 */
class InitCommandBuilder extends AbstractCommandBuilder
{
    const SHARE_FALSE = 'false';

    const SHARE_TRUE = 'true';

    const SHARE_UMASK = 'umask';

    const SHARE_GROUP = 'group';

    const SHARE_ALL = 'all';

    const SHARE_WORLD = 'world';

    const SHARE_EVERYBODY = 'everybody';

    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('init');
    }

    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    public function bare()
    {
        $this->processBuilder->add('--bare');
        return $this;
    }

    public function template($templateDirectory)
    {
        $this->processBuilder->add('--template=' . $templateDirectory);
        return $this;
    }

    public function separateGitDir($gitDir)
    {
        $this->processBuilder->add('--separate-git-dir=' . $gitDir);
        return $this;
    }

    public function shared($share)
    {
        $this->processBuilder->add('--shared=' . $share);
        return $this;
    }

    public function execute()
    {
        $this->processBuilder->add($this->repository->getRepositoryPath());
        return parent::run();
    }
}
