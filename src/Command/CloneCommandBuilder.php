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
 * Clone command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CloneCommandBuilder extends AbstractCommandBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('clone');
    }

    /**
     * Add the local option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function local()
    {
        $this->processBuilder->add('--local');
        return $this;
    }

    /**
     * Add the no-hardlinks option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noHardlinks()
    {
        $this->processBuilder->add('--no-hardlinks');
        return $this;
    }

    /**
     * Add the shared option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function shared()
    {
        $this->processBuilder->add('--shared');
        return $this;
    }

    /**
     * Add the reference option to the command line.
     *
     * @param string $repository The repository name.
     *
     * @return CloneCommandBuilder
     */
    public function reference($repository)
    {
        $this->processBuilder->add('--reference')->add($repository);
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the progress option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function progress()
    {
        $this->processBuilder->add('--progress');
        return $this;
    }

    /**
     * Add the no-checkout option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noCheckout()
    {
        $this->processBuilder->add('--no-checkout');
        return $this;
    }

    /**
     * Add the bare option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function bare()
    {
        $this->processBuilder->add('--bare');
        return $this;
    }

    /**
     * Add the mirror option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function mirror()
    {
        $this->processBuilder->add('--mirror');
        return $this;
    }

    /**
     * Add the origin option to the command line.
     *
     * @param string $name The name of the origin.
     *
     * @return CloneCommandBuilder
     */
    public function origin($name)
    {
        $this->processBuilder->add('--origin')->add($name);
        return $this;
    }

    /**
     * Add the branch option to the command line.
     *
     * @param string $name The branch name.
     *
     * @return CloneCommandBuilder
     */
    public function branch($name)
    {
        $this->processBuilder->add('--branch')->add($name);
        return $this;
    }

    /**
     * Add the upload-pack option to the command line.
     *
     * @param string $uploadPack The upload pack.
     *
     * @return CloneCommandBuilder
     */
    public function uploadPack($uploadPack)
    {
        $this->processBuilder->add('--upload-pack')->add($uploadPack);
        return $this;
    }

    /**
     * Add the template option to the command line.
     *
     * @param string $templateDirectory The template directory.
     *
     * @return CloneCommandBuilder
     */
    public function template($templateDirectory)
    {
        $this->processBuilder->add('--template=' . $templateDirectory);
        return $this;
    }

    /**
     * Add the config option to the command line.
     *
     * @param string $key   The config key.
     *
     * @param string $value The config value.
     *
     * @return CloneCommandBuilder
     */
    public function config($key, $value)
    {
        $this->processBuilder->add('--config')->add($key . '=' . $value);
        return $this;
    }

    /**
     * Add the depth option to the command line.
     *
     * @param string $depth The depth.
     *
     * @return CloneCommandBuilder
     */
    public function depth($depth)
    {
        $this->processBuilder->add('--depth')->add($depth);
        return $this;
    }

    /**
     * Add the no-single-branch option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noSingleBranch()
    {
        $this->processBuilder->add('--no-single-branch');
        return $this;
    }

    /**
     * Add the single-branch option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function singleBranch()
    {
        $this->processBuilder->add('--single-branch');
        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function recursive()
    {
        $this->processBuilder->add('--recursive');
        return $this;
    }

    /**
     * Add the separate-git-dir option to the command line.
     *
     * @param string $gitDir The git dir to use.
     *
     * @return CloneCommandBuilder
     */
    public function separateGitDir($gitDir)
    {
        $this->processBuilder->add('--separate-git-dir=' . $gitDir);
        return $this;
    }

    /**
     * Execute the command and return the result.
     *
     * @param string $repositoryUrl The url of the repository.
     *
     * @return mixed
     */
    public function execute($repositoryUrl)
    {
        $this->processBuilder->add($repositoryUrl);
        $this->processBuilder->add($this->repository->getRepositoryPath());
        return parent::run();
    }
}
