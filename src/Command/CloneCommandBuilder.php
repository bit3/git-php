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
        $this->arguments[] = 'clone';
    }

    /**
     * Add the local option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function local()
    {
        $this->arguments[] = '--local';
        return $this;
    }

    /**
     * Add the no-hardlinks option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noHardlinks()
    {
        $this->arguments[] = '--no-hardlinks';
        return $this;
    }

    /**
     * Add the shared option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function shared()
    {
        $this->arguments[] = '--shared';
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
        $this->arguments[] = '--reference';
        $this->arguments[] = $repository;
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function verbose()
    {
        $this->arguments[] = '--verbose';
        return $this;
    }

    /**
     * Add the progress option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function progress()
    {
        $this->arguments[] = '--progress';
        return $this;
    }

    /**
     * Add the no-checkout option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noCheckout()
    {
        $this->arguments[] = '--no-checkout';
        return $this;
    }

    /**
     * Add the bare option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function bare()
    {
        $this->arguments[] = '--bare';
        return $this;
    }

    /**
     * Add the mirror option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function mirror()
    {
        $this->arguments[] = '--mirror';
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
        $this->arguments[] = '--origin';
        $this->arguments[] = $name;
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
        $this->arguments[] = '--branch';
        $this->arguments[] = $name;
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
        $this->arguments[] = '--upload-pack';
        $this->arguments[] = $uploadPack;
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
        $this->arguments[] = '--template=' . $templateDirectory;
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
        $this->arguments[] = '--config';
        $this->arguments[] = $key . '=' . $value;
        return $this;
    }

    /**
     * Add the depth option to the command line.
     *
     * @param string $depth The depth.arguments[] = rn CloneCommandBuildr.
     *
     * @return CloneCommandBuilder
     */
    public function depth($depth)
    {
        $this->arguments[] = '--depth';
        $this->arguments[] = $depth;
        return $this;
    }

    /**
     * Add the no-single-branch option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function noSingleBranch()
    {
        $this->arguments[] = '--no-single-branch';
        return $this;
    }

    /**
     * Add the single-branch option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function singleBranch()
    {
        $this->arguments[] = '--single-branch';
        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @return CloneCommandBuilder
     */
    public function recursive()
    {
        $this->arguments[] = '--recursive';
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
        $this->arguments[] = '--separate-git-dir=' . $gitDir;
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
        $this->arguments[] = $repositoryUrl;
        $this->arguments[] = $this->repository->getRepositoryPath();
        return parent::run();
    }
}
