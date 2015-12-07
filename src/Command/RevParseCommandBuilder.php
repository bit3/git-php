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
 * Rev-parse command builder.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class RevParseCommandBuilder extends AbstractCommandBuilder
{
    const ABBREV_REF_STRICT = 'strict';

    const ABBREV_REF_LOOSE = 'loose';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('rev-parse');
    }

    /**
     * Add the parseopt option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function parseopt()
    {
        $this->processBuilder->add('--parseopt');
        return $this;
    }

    /**
     * Add the keep-dashdash option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function keepDashDash()
    {
        $this->processBuilder->add('--keep-dashdash');
        return $this;
    }

    /**
     * Add the stop-at-non-option option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function stopAtNonOption()
    {
        $this->processBuilder->add('--stop-at-non-option');
        return $this;
    }

    /**
     * Add the stuck-long option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function stuckLong()
    {
        $this->processBuilder->add('--stuck-long');
        return $this;
    }

    /**
     * Add the sq-quote option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function sqQuote()
    {
        $this->processBuilder->add('--sq-quote');
        return $this;
    }

    /**
     * Add the revs-only option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function revsOnly()
    {
        $this->processBuilder->add('--revs-only');
        return $this;
    }

    /**
     * Add the no-revs option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function noRevs()
    {
        $this->processBuilder->add('--no-revs');
        return $this;
    }

    /**
     * Add the flags option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function flags()
    {
        $this->processBuilder->add('--flags');
        return $this;
    }

    /**
     * Add the no-flags option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function noFlags()
    {
        $this->processBuilder->add('--no-flags');
        return $this;
    }

    /**
     * Add the default option to the command line.
     *
     * @param string $arg Name of the default rev.
     *
     * @return RevParseCommandBuilder
     */
    public function defaultRev($arg)
    {
        $this->processBuilder->add('--default')->add($arg);
        return $this;
    }

    /**
     * Add the prefix option to the command line.
     *
     * @param string $arg The prefix.
     *
     * @return RevParseCommandBuilder
     */
    public function prefix($arg)
    {
        $this->processBuilder->add('--prefix')->add($arg);
        return $this;
    }

    /**
     * Add the verify option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function verify()
    {
        $this->processBuilder->add('--verify');
        return $this;
    }

    /**
     * Add the quiet option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function quiet()
    {
        $this->processBuilder->add('--quiet');
        return $this;
    }

    /**
     * Add the sq option to the command line.
     *
     * @return RevParseCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function sq()
    {
        $this->processBuilder->add('--sq');
        return $this;
    }

    /**
     * Add the not option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function not()
    {
        $this->processBuilder->add('--not');
        return $this;
    }

    /**
     * Add the abbref-ref option to the command line.
     *
     * @param null|string $abbrev The value.
     *
     * @return RevParseCommandBuilder
     */
    public function abbrevRef($abbrev = null)
    {
        $this->processBuilder->add('--abbref-ref' . ($abbrev ? '=' . $abbrev : ''));
        return $this;
    }

    /**
     * Add the short option to the command line.
     *
     * @param null|int $number The amount.
     *
     * @return RevParseCommandBuilder
     */
    public function short($number = null)
    {
        $this->processBuilder->add('--short' . ($number ? '=' . $number : ''));
        return $this;
    }

    /**
     * Add the symbolic option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function symbolic()
    {
        $this->processBuilder->add('--symbolic');
        return $this;
    }

    /**
     * Add the symbolic-full-name option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function symbolicFullName()
    {
        $this->processBuilder->add('--symbolic-full-name');
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return RevParseCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the branches option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return RevParseCommandBuilder
     */
    public function branches($pattern)
    {
        $this->processBuilder->add('--branches=' . $pattern);
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return RevParseCommandBuilder
     */
    public function tags($pattern)
    {
        $this->processBuilder->add('--tags=' . $pattern);
        return $this;
    }

    /**
     * Add the remotes option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return RevParseCommandBuilder
     */
    public function remotes($pattern)
    {
        $this->processBuilder->add('--remotes=' . $pattern);
        return $this;
    }

    /**
     * Add the glob option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return RevParseCommandBuilder
     */
    public function glob($pattern)
    {
        $this->processBuilder->add('--glob=' . $pattern);
        return $this;
    }

    /**
     * Add the exclude option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return RevParseCommandBuilder
     */
    public function exclude($pattern)
    {
        $this->processBuilder->add('--exclude=' . $pattern);
        return $this;
    }

    /**
     * Add the disambiguate option to the command line.
     *
     * @param string $prefix The prefix.
     *
     * @return RevParseCommandBuilder
     */
    public function disambiguate($prefix)
    {
        $this->processBuilder->add('--disambiguate=' . $prefix);
        return $this;
    }

    /**
     * Add the since option to the command line.
     *
     * @param \DateTime|string $date The date.
     *
     * @return RevParseCommandBuilder
     */
    public function since($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--since=' . $date);
        return $this;
    }

    /**
     * Add the after option to the command line.
     *
     * @param \DateTime|string $date The date.
     *
     * @return RevParseCommandBuilder
     */
    public function after($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--after=' . $date);
        return $this;
    }

    /**
     * Add the until option to the command line.
     *
     * @param \DateTime|string $date The date.
     *
     * @return RevParseCommandBuilder
     */
    public function until($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--until=' . $date);
        return $this;
    }

    /**
     * Add the before option to the command line.
     *
     * @param \DateTime|string $date The date.
     *
     * @return RevParseCommandBuilder
     */
    public function before($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->processBuilder->add('--before=' . $date);
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $arg Optional additional argument.
     *
     * @param null|string $_   More optional arguments.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($arg = null, $_ = null)
    {
        foreach (func_get_args() as $arg) {
            $this->processBuilder->add($arg);
        }
        return parent::run();
    }
}
