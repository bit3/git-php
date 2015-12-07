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
 * Log command builder.
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class LogCommandBuilder extends AbstractCommandBuilder
{
    const DECORATE_SHORT = 'short';

    const DECORATE_FULL = 'full';

    const DECORATE_NO = 'no';

    const WALK_SORTED = 'sorted';

    const WALK_UNSORTED = 'unsorted';

    const DATE_RELATIVE = 'relative';

    const DATE_LOCAL = 'local';

    const DATE_DEFAULT = 'default';

    const DATE_ISO = 'iso';

    const DATE_RFC = 'rfc';

    const DATE_SHORT = 'short';

    const DATE_RAW = 'raw';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->processBuilder->add('log');
    }

    /**
     * Add the follow option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function follow()
    {
        $this->processBuilder->add('--follow');
        return $this;
    }

    /**
     * Add the no-decorate option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noDecorate()
    {
        $this->processBuilder->add('--no-decorate');
        return $this;
    }

    /**
     * Add the decorate option to the command line.
     *
     * @param string $decorate The decorator value to use.
     *
     * @return LogCommandBuilder
     */
    public function decorate($decorate)
    {
        $this->processBuilder->add('--decorate' . ($decorate ? '=' . $decorate : ''));
        return $this;
    }

    /**
     * Add the source option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function source()
    {
        $this->processBuilder->add('--source');
        return $this;
    }

    /**
     * Add the use-mailmap option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function useMailmap()
    {
        $this->processBuilder->add('--use-mailmap');
        return $this;
    }

    /**
     * Add the full-diff option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fullDiff()
    {
        $this->processBuilder->add('--full-diff');
        return $this;
    }

    /**
     * Add the log-size option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function logSize()
    {
        $this->processBuilder->add('--log-size');
        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @param string $revisionRange The revision range.
     *
     * @return LogCommandBuilder
     */
    public function revisionRange($revisionRange)
    {
        $this->processBuilder->add($revisionRange);
        return $this;
    }

    /**
     * Add the max-count option to the command line.
     *
     * @param int $number Amount of log entries.
     *
     * @return LogCommandBuilder
     */
    public function maxCount($number)
    {
        $this->processBuilder->add('--max-count=' . $number);
        return $this;
    }

    /**
     * Add the skip option to the command line.
     *
     * @param int $number Amount of entries to skip.
     *
     * @return LogCommandBuilder
     */
    public function skip($number)
    {
        $this->processBuilder->add('--skip=' . $number);
        return $this;
    }

    /**
     * Add the since option to the command line.
     *
     * @param \DateTime|string $date The date from which on the commits shall be listed.
     *
     * @return LogCommandBuilder
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
     * @param \DateTime|string $date The date after which the commits shall be listed.
     *
     * @return LogCommandBuilder
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
     * @param \DateTime|string $date The date until which the commits shall be listed.
     *
     * @return LogCommandBuilder
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
     * @param \DateTime|string $date The date before which the commits shall be listed.
     *
     * @return LogCommandBuilder
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
     * Add the author option to the command line.
     *
     * @param string $pattern The pattern the author has to match.
     *
     * @return LogCommandBuilder
     */
    public function author($pattern)
    {
        $this->processBuilder->add('--author=' . $pattern);
        return $this;
    }

    /**
     * Add the grep-reflog option to the command line.
     *
     * @param string $pattern The pattern to grep the ref log with.
     *
     * @return LogCommandBuilder
     */
    public function grepReflog($pattern)
    {
        $this->processBuilder->add('--grep-reflog=' . $pattern);
        return $this;
    }

    /**
     * Add the grep option to the command line.
     *
     * @param string $pattern The pattern.
     *
     * @return LogCommandBuilder
     */
    public function grep($pattern)
    {
        $this->processBuilder->add('--grep=' . $pattern);
        return $this;
    }

    /**
     * Add the all-match option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function allMatch()
    {
        $this->processBuilder->add('--all-match');
        return $this;
    }

    /**
     * Add the regexp-ignore-case option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function regexpIgnoreCase()
    {
        $this->processBuilder->add('--regexp-ignore-case');
        return $this;
    }

    /**
     * Add the basicRegexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function basicRegexp()
    {
        $this->processBuilder->add('--basicRegexp');
        return $this;
    }

    /**
     * Add the extended-regexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function extendedRegexp()
    {
        $this->processBuilder->add('--extended-regexp');
        return $this;
    }

    /**
     * Add the fixed-strings option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fixedStrings()
    {
        $this->processBuilder->add('--fixed-strings');
        return $this;
    }

    /**
     * Add the perl-regexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function perlRegexp()
    {
        $this->processBuilder->add('--perl-regexp');
        return $this;
    }

    /**
     * Add the remove-empty option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function removeEmpty()
    {
        $this->processBuilder->add('--remove-empty');
        return $this;
    }

    /**
     * Add the merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function merges()
    {
        $this->processBuilder->add('--merges');
        return $this;
    }

    /**
     * Add the no-merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMerges()
    {
        $this->processBuilder->add('--no-merges');
        return $this;
    }

    /**
     * Add the min-parents option to the command line.
     *
     * @param int $number The minimum amount of parents.
     *
     * @return LogCommandBuilder
     */
    public function minParents($number)
    {
        $this->processBuilder->add('--min-parents=' . $number);
        return $this;
    }

    /**
     * Add the max-parents option to the command line.
     *
     * @param int $number The maximum amount of parents.
     *
     * @return LogCommandBuilder
     */
    public function maxParents($number)
    {
        $this->processBuilder->add('--max-parents=' . $number);
        return $this;
    }

    /**
     * Add the no-min-parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMinParents()
    {
        $this->processBuilder->add('--no-min-parents');
        return $this;
    }

    /**
     * Add the no-max-parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMaxParents()
    {
        $this->processBuilder->add('--no-max-parents');
        return $this;
    }

    /**
     * Add the first-parent option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function firstParent()
    {
        $this->processBuilder->add('--first-parent');
        return $this;
    }

    /**
     * Add the not option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function not()
    {
        $this->processBuilder->add('--not');
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function all()
    {
        $this->processBuilder->add('--all');
        return $this;
    }

    /**
     * Add the branches option to the command line.
     *
     * @param null|string $pattern The pattern to filter branches with.
     *
     * @return LogCommandBuilder
     */
    public function branches($pattern = null)
    {
        $this->processBuilder->add('--branches' . ($pattern ? '=' . $pattern : ''));
        return $this;
    }

    /**
     * Add the tags option to the command line.
     *
     * @param null|string $pattern The pattern to filter the tags with.
     *
     * @return LogCommandBuilder
     */
    public function tags($pattern = null)
    {
        $this->processBuilder->add('--tags' . ($pattern ? '=' . $pattern : ''));
        return $this;
    }

    /**
     * Add the remotes option to the command line.
     *
     * @param null|string $pattern The pattern to filter the remotes with.
     *
     * @return LogCommandBuilder
     */
    public function remotes($pattern = null)
    {
        $this->processBuilder->add('--remotes' . ($pattern ? '=' . $pattern : ''));
        return $this;
    }

    /**
     * Add the glob option to the command line.
     *
     * @param null|string $pattern The glob pattern.
     *
     * @return LogCommandBuilder
     */
    public function glob($pattern = null)
    {
        $this->processBuilder->add('--glob=' . $pattern);
        return $this;
    }

    /**
     * Add the exclude option to the command line.
     *
     * @param null|string $pattern The pattern to exclude.
     *
     * @return LogCommandBuilder
     */
    public function exclude($pattern = null)
    {
        $this->processBuilder->add('--exclude=' . $pattern);
        return $this;
    }

    /**
     * Add the ignore-missing option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function ignoreMissing()
    {
        $this->processBuilder->add('--ignore-missing');
        return $this;
    }

    /**
     * Add the bisect option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function bisect()
    {
        $this->processBuilder->add('--bisect');
        return $this;
    }

    /**
     * Add the cherry-mark option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherryMark()
    {
        $this->processBuilder->add('--cherry-mark');
        return $this;
    }

    /**
     * Add the cherry-pick option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherryPick()
    {
        $this->processBuilder->add('--cherry-pick');
        return $this;
    }

    /**
     * Add the left-only option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function leftOnly()
    {
        $this->processBuilder->add('--left-only');
        return $this;
    }

    /**
     * Add the right-only option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function rightOnly()
    {
        $this->processBuilder->add('--right-only');
        return $this;
    }

    /**
     * Add the cherry option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherry()
    {
        $this->processBuilder->add('--cherry');
        return $this;
    }

    /**
     * Add the walk-reflogs option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function walkReflogs()
    {
        $this->processBuilder->add('--walk-reflogs');
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function merge()
    {
        $this->processBuilder->add('--merge');
        return $this;
    }

    /**
     * Add the boundary option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function boundary()
    {
        $this->processBuilder->add('--boundary');
        return $this;
    }

    /**
     * Add the simplify-by-decoration option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function simplifyByDecoration()
    {
        $this->processBuilder->add('--simplify-by-decoration');
        return $this;
    }

    /**
     * Add the full-history option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fullHistory()
    {
        $this->processBuilder->add('--full-history');
        return $this;
    }

    /**
     * Add the dense option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function dense()
    {
        $this->processBuilder->add('--dense');
        return $this;
    }

    /**
     * Add the sparse option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function sparse()
    {
        $this->processBuilder->add('--sparse');
        return $this;
    }

    /**
     * Add the simplify-merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function simplifyMerges()
    {
        $this->processBuilder->add('--simplify-merges');
        return $this;
    }

    /**
     * Add the ancestry-path option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function ancestryPath()
    {
        $this->processBuilder->add('--ancestry-path');
        return $this;
    }

    /**
     * Add the date-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function dateOrder()
    {
        $this->processBuilder->add('--date-order');
        return $this;
    }

    /**
     * Add the author-date-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function authorDateOrder()
    {
        $this->processBuilder->add('--author-date-order');
        return $this;
    }

    /**
     * Add the topo-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function topoOrder()
    {
        $this->processBuilder->add('--topo-order');
        return $this;
    }

    /**
     * Add the reverse option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function reverse()
    {
        $this->processBuilder->add('--reverse');
        return $this;
    }

    /**
     * Add the objects option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function objects()
    {
        $this->processBuilder->add('--objects');
        return $this;
    }

    /**
     * Add the objects-edge option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function objectsEdge()
    {
        $this->processBuilder->add('--objects-edge');
        return $this;
    }

    /**
     * Add the unpacked option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function unpacked()
    {
        $this->processBuilder->add('--unpacked');
        return $this;
    }

    /**
     * Add the no-walk option to the command line.
     *
     * @param null|string $walk The value.
     *
     * @return LogCommandBuilder
     */
    public function noWalk($walk = null)
    {
        $this->processBuilder->add('--no-walk' . ($walk ? '=' . $walk : ''));
        return $this;
    }

    /**
     * Add the do-walk option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function doWalk()
    {
        $this->processBuilder->add('--do-walk');
        return $this;
    }

    /**
     * Add the pretty option to the command line.
     *
     * @param null|string $format The format.
     *
     * @return LogCommandBuilder
     */
    public function pretty($format = null)
    {
        $this->processBuilder->add('--pretty' . ($format ? '=' . $format : ''));
        return $this;
    }

    /**
     * Add the format option to the command line.
     *
     * @param string $format The format.
     *
     * @return LogCommandBuilder
     */
    public function format($format)
    {
        $this->processBuilder->add('--format=' . $format);
        return $this;
    }

    /**
     * Add the abbrev-commit option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function abbrevCommit()
    {
        $this->processBuilder->add('--abbrev-commit');
        return $this;
    }

    /**
     * Add the no-abbrev-commit option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noAbbrevCommit()
    {
        $this->processBuilder->add('--no-abbrev-commit');
        return $this;
    }

    /**
     * Add the oneline option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function oneline()
    {
        $this->processBuilder->add('--oneline');
        return $this;
    }

    /**
     * Add the encoding option to the command line.
     *
     * @param string $encoding The encoding.
     *
     * @return LogCommandBuilder
     */
    public function encoding($encoding)
    {
        $this->processBuilder->add('--encoding=' . $encoding);
        return $this;
    }

    /**
     * Add the notes option to the command line.
     *
     * @param null|string $ref The ref name.
     *
     * @return LogCommandBuilder
     */
    public function notes($ref = null)
    {
        $this->processBuilder->add('--notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    /**
     * Add the no-notes option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noNotes()
    {
        $this->processBuilder->add('--no-notes');
        return $this;
    }

    /**
     * Add the show-notes option to the command line.
     *
     * @param null|string $ref The name of the ref.
     *
     * @return LogCommandBuilder
     */
    public function showNotes($ref = null)
    {
        $this->processBuilder->add('--show-notes' . ($ref ? '=' . $ref : ''));
        return $this;
    }

    /**
     * Add the show-signature option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function showSignature()
    {
        $this->processBuilder->add('--show-signature');
        return $this;
    }

    /**
     * Add the relative-date option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function relativeDate()
    {
        $this->processBuilder->add('--relative-date');
        return $this;
    }

    /**
     * Add the date option to the command line.
     *
     * @param string $format The date format.
     *
     * @return LogCommandBuilder
     */
    public function date($format)
    {
        $this->processBuilder->add('--date=' . $format);
        return $this;
    }

    /**
     * Add the parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function parents()
    {
        $this->processBuilder->add('--parents');
        return $this;
    }

    /**
     * Add the children option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function children()
    {
        $this->processBuilder->add('--children');
        return $this;
    }

    /**
     * Add the left-right option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function leftRight()
    {
        $this->processBuilder->add('--left-right');
        return $this;
    }

    /**
     * Add the graph option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function graph()
    {
        $this->processBuilder->add('--graph');
        return $this;
    }

    /**
     * Add the c option to the command line.
     *
     * @return LogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function c()
    {
        $this->processBuilder->add('-c');
        return $this;
    }

    /**
     * Add the cc option to the command line.
     *
     * @return LogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function cc()
    {
        $this->processBuilder->add('--cc');
        return $this;
    }

    /**
     * Add the m option to the command line.
     *
     * @return LogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function m()
    {
        $this->processBuilder->add('-m');
        return $this;
    }

    /**
     * Add the r option to the command line.
     *
     * @return LogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function r()
    {
        $this->processBuilder->add('-r');
        return $this;
    }

    /**
     * Add the t option to the command line.
     *
     * @return LogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function t()
    {
        $this->processBuilder->add('-t');
        return $this;
    }

    /**
     * Build the command and execute it.
     *
     * @param null|string $pathspec Path spec to log.
     *
     * @param null|string $_        More optional pathspecs to log.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathspec = null, $_ = null)
    {
        $args = func_get_args();
        if (count($args)) {
            $this->processBuilder->add('--');
            foreach ($args as $pathspec) {
                $this->processBuilder->add($pathspec);
            }
        }
        return parent::run();
    }
}
