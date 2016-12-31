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
 * @author     Ahmad Marzouq <ahmad.marzouq@eagles-web.com>
 * @copyright  2014 Tristan Lins <tristan@lins.io>
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
class PullCommandBuilder extends AbstractCommandBuilder
{

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('pull');
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return PullCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the verbose option to the command line.
     *
     * @return PullCommandBuilder
     */
    public function verbose()
    {
        $this->processBuilder->add('--verbose');
        return $this;
    }

    /**
     * Add the recurse-submodules option to the command line.
     *
     * @param string $recurse The value.
     *
     * @return PushCommandBuilder
     */
    public function recurseSubmodules($recurse)
    {
        $this->processBuilder->add('--recurse-submodules=' . $recurse);
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
    public function execute($repository, $refspec = null, $_ = null)
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

