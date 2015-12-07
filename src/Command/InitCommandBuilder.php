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

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('init');
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the bare option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function bare()
    {
        $this->processBuilder->add('--bare');
        return $this;
    }

    /**
     * Add the template option to the command line.
     *
     * @param string $templateDirectory Path to the template directory.
     *
     * @return FetchCommandBuilder
     */
    public function template($templateDirectory)
    {
        $this->processBuilder->add('--template=' . $templateDirectory);
        return $this;
    }

    /**
     * Add the separate-git-dir option to the command line.
     *
     * @param string $gitDir Path to the .git dir.
     *
     * @return FetchCommandBuilder
     */
    public function separateGitDir($gitDir)
    {
        $this->processBuilder->add('--separate-git-dir=' . $gitDir);
        return $this;
    }

    /**
     * Add the shared option to the command line.
     *
     * @param string $share The share value.
     *
     * @return FetchCommandBuilder
     */
    public function shared($share)
    {
        $this->processBuilder->add('--shared=' . $share);
        return $this;
    }

    /**
     * Execute the command and return the output.
     *
     * @return string
     */
    public function execute()
    {
        $this->processBuilder->add($this->repository->getRepositoryPath());
        return parent::run();
    }
}
