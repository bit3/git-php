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
 * Fetch command builder.
 */
class FetchCommandBuilder extends AbstractCommandBuilder
{
    const RECURSE_SUBMODULES_YES = 'yes';

    const RECURSE_SUBMODULES_ON_DEMAND = 'on-demand';

    const RECURSE_SUBMODULES_NO = 'no';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('fetch');
    }

    /**
     * Add the all option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the append option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function append()
    {
        $this->processBuilder->add('--append');
        return $this;
    }

    /**
     * Add the depth option to the command line.
     *
     * @param int $depth The commit depth to use.
     *
     * @return FetchCommandBuilder
     */
    public function depth($depth)
    {
        $this->processBuilder->add('--depth=' . $depth);
        return $this;
    }

    /**
     * Add the unshallow option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function unshallow()
    {
        $this->processBuilder->add('--unshallow');
        return $this;
    }

    /**
     * Add the update-shallow option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function updateShallow()
    {
        $this->processBuilder->add('--update-shallow');
        return $this;
    }

    /**
     * Add the dry-run option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function dryRun()
    {
        $this->processBuilder->add('--dry-run');
        return $this;
    }

    /**
     * Add the force option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function force()
    {
        $this->processBuilder->add('--force');
        return $this;
    }

    /**
     * Add the keep option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function keep()
    {
        $this->processBuilder->add('--keep');
        return $this;
    }

    /**
     * Add the multiple option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function multiple()
    {
        $this->processBuilder->add('--multiple');
        return $this;
    }

    /**
     * Add the prune option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function prune()
    {
        $this->processBuilder->add('--prune');
        return $this;
    }

    /**
     * Add the no-tags option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function noTags()
    {
        $this->processBuilder->add('--no-tags');
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function tags()
    {
        $this->processBuilder->add('--tags');
        return $this;
    }

    /**
     * Add the recurse-submodules option to the command line.
     *
     * @param bool|string $recurse The value.
     *
     * @return FetchCommandBuilder
     */
    public function recurseSubmodules($recurse = false)
    {
        $this->processBuilder->add('--recurse-submodules' . ($recurse ? '=' . $recurse : ''));
        return $this;
    }

    /**
     * Add the no-recurse-submodules option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function noRecurseSubmodules()
    {
        $this->processBuilder->add('--no-recurse-submodules');
        return $this;
    }

    /**
     * Add the submodule-prefix option to the command line.
     *
     * @param string $path The path.
     *
     * @return FetchCommandBuilder
     */
    public function submodulePrefix($path)
    {
        $this->processBuilder->add('--submodule-prefix=' . $path);
        return $this;
    }

    /**
     * Add the recurse-submodules-default option to the command line.
     *
     * @param string $recurse The value.
     *
     * @return FetchCommandBuilder
     */
    public function recurseSubmodulesDefault($recurse)
    {
        $this->processBuilder->add('--recurse-submodules-default=' . $recurse);
        return $this;
    }

    /**
     * Add the update-head-ok option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function updateHeadOk()
    {
        $this->processBuilder->add('--update-head-ok');
        return $this;
    }

    /**
     * Add the upload-pack option to the command line.
     *
     * @param string $uploadPack The pack.
     *
     * @return FetchCommandBuilder
     */
    public function uploadPack($uploadPack)
    {
        $this->processBuilder->add('--upload-pack')->add($uploadPack);
        return $this;
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
     * Add the verbose option to the command line.
     *
     * @return FetchCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string      $repository Name of the remote to use (Defaults to origin).
     *
     * @param null|string $refspec    Refspec to fetch.
     *
     * @param null|string $_          More optional refspecs to commit.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($repository = 'origin', $refspec = null, $_ = null)
    {
        $this->processBuilder->add($repository);

        $refspecs = func_get_args();
        array_shift($refspecs);
        foreach ($refspecs as $refspec) {
            $this->processBuilder->add($refspec);
        }

        return parent::run();
    }
}
