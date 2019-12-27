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
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * Pull command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class PullCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'pull';
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return PullCommandBuilder
     */
    public function quiet()
    {
        $this->arguments[] = '--quiet';
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return PullCommandBuilder
     */
    public function verbose()
    {
        $this->arguments[] = '--verbose';
        return $this;
    }

    /**
     * Add the recurse-submodules option to the command line.
     *
     * @param string $recurse The value.
     *
     * @return PullCommandBuilder
     */
    public function recurseSubmodules($recurse)
    {
        $this->arguments[] = '--recurse-submodules=' . $recurse;
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param string      $repository Name of the remote to pull from.
     *
     * @param null|string $refspec    Ref spec to pull.
     *
     * @param null|string $_          More optional ref specs to pull.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($repository = 'origin', $refspec = null, $_ = null)
    {
        $this->arguments[] = $repository;

        $refspecs = \func_get_args();
        \array_shift($refspecs);
        foreach ($refspecs as $refspec) {
            $this->arguments[] = $refspec;
        }

        return $this->run();
    }
}
