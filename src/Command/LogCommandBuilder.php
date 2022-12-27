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
 * @copyright  2014-2022 Tristan Lins <tristan@lins.io>
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
class LogCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    public const DECORATE_SHORT = 'short';

    public const DECORATE_FULL = 'full';

    public const DECORATE_NO = 'no';

    public const WALK_SORTED = 'sorted';

    public const WALK_UNSORTED = 'unsorted';

    public const DATE_RELATIVE = 'relative';

    public const DATE_LOCAL = 'local';

    public const DATE_DEFAULT = 'default';

    public const DATE_ISO = 'iso';

    public const DATE_RFC = 'rfc';

    public const DATE_SHORT = 'short';

    public const DATE_RAW = 'raw';

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'log';
    }

    /**
     * Add the follow option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function follow()
    {
        $this->arguments[] = '--follow';
        return $this;
    }

    /**
     * Add the no-decorate option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noDecorate()
    {
        $this->arguments[] = '--no-decorate';
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
        $this->arguments[] = '--decorate' . ($decorate ? '=' . $decorate : '');
        return $this;
    }

    /**
     * Add the source option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function source()
    {
        $this->arguments[] = '--source';
        return $this;
    }

    /**
     * Add the use-mailmap option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function useMailmap()
    {
        $this->arguments[] = '--use-mailmap';
        return $this;
    }

    /**
     * Add the full-diff option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fullDiff()
    {
        $this->arguments[] = '--full-diff';
        return $this;
    }

    /**
     * Add the log-size option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function logSize()
    {
        $this->arguments[] = '--log-size';
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
        $this->arguments[] = $revisionRange;
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
        $this->arguments[] = '--max-count=' . $number;
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
        $this->arguments[] = '--skip=' . $number;
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
        $this->arguments[] = '--since=' . $date;
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
        $this->arguments[] = '--after=' . $date;
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
        $this->arguments[] = '--until=' . $date;
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
        $this->arguments[] = '--before=' . $date;
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
        $this->arguments[] = '--author=' . $pattern;
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
        $this->arguments[] = '--grep-reflog=' . $pattern;
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
        $this->arguments[] = '--grep=' . $pattern;
        return $this;
    }

    /**
     * Add the all-match option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function allMatch()
    {
        $this->arguments[] = '--all-match';
        return $this;
    }

    /**
     * Add the regexp-ignore-case option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function regexpIgnoreCase()
    {
        $this->arguments[] = '--regexp-ignore-case';
        return $this;
    }

    /**
     * Add the basicRegexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function basicRegexp()
    {
        $this->arguments[] = '--basicRegexp';
        return $this;
    }

    /**
     * Add the extended-regexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function extendedRegexp()
    {
        $this->arguments[] = '--extended-regexp';
        return $this;
    }

    /**
     * Add the fixed-strings option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fixedStrings()
    {
        $this->arguments[] = '--fixed-strings';
        return $this;
    }

    /**
     * Add the perl-regexp option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function perlRegexp()
    {
        $this->arguments[] = '--perl-regexp';
        return $this;
    }

    /**
     * Add the remove-empty option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function removeEmpty()
    {
        $this->arguments[] = '--remove-empty';
        return $this;
    }

    /**
     * Add the merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function merges()
    {
        $this->arguments[] = '--merges';
        return $this;
    }

    /**
     * Add the no-merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMerges()
    {
        $this->arguments[] = '--no-merges';
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
        $this->arguments[] = '--min-parents=' . $number;
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
        $this->arguments[] = '--max-parents=' . $number;
        return $this;
    }

    /**
     * Add the no-min-parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMinParents()
    {
        $this->arguments[] = '--no-min-parents';
        return $this;
    }

    /**
     * Add the no-max-parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noMaxParents()
    {
        $this->arguments[] = '--no-max-parents';
        return $this;
    }

    /**
     * Add the first-parent option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function firstParent()
    {
        $this->arguments[] = '--first-parent';
        return $this;
    }

    /**
     * Add the not option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function not()
    {
        $this->arguments[] = '--not';
        return $this;
    }

    /**
     * Add the all option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function all()
    {
        $this->arguments[] = '--all';
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
        $this->arguments[] = '--branches' . ($pattern ? '=' . $pattern : '');
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
        $this->arguments[] = '--tags' . ($pattern ? '=' . $pattern : '');
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
        $this->arguments[] = '--remotes' . ($pattern ? '=' . $pattern : '');
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
        $this->arguments[] = '--glob=' . $pattern;
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
        $this->arguments[] = '--exclude=' . $pattern;
        return $this;
    }

    /**
     * Add the ignore-missing option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function ignoreMissing()
    {
        $this->arguments[] = '--ignore-missing';
        return $this;
    }

    /**
     * Add the bisect option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function bisect()
    {
        $this->arguments[] = '--bisect';
        return $this;
    }

    /**
     * Add the cherry-mark option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherryMark()
    {
        $this->arguments[] = '--cherry-mark';
        return $this;
    }

    /**
     * Add the cherry-pick option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherryPick()
    {
        $this->arguments[] = '--cherry-pick';
        return $this;
    }

    /**
     * Add the left-only option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function leftOnly()
    {
        $this->arguments[] = '--left-only';
        return $this;
    }

    /**
     * Add the right-only option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function rightOnly()
    {
        $this->arguments[] = '--right-only';
        return $this;
    }

    /**
     * Add the cherry option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function cherry()
    {
        $this->arguments[] = '--cherry';
        return $this;
    }

    /**
     * Add the walk-reflogs option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function walkReflogs()
    {
        $this->arguments[] = '--walk-reflogs';
        return $this;
    }

    /**
     * Add the merge option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function merge()
    {
        $this->arguments[] = '--merge';
        return $this;
    }

    /**
     * Add the boundary option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function boundary()
    {
        $this->arguments[] = '--boundary';
        return $this;
    }

    /**
     * Add the simplify-by-decoration option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function simplifyByDecoration()
    {
        $this->arguments[] = '--simplify-by-decoration';
        return $this;
    }

    /**
     * Add the full-history option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function fullHistory()
    {
        $this->arguments[] = '--full-history';
        return $this;
    }

    /**
     * Add the dense option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function dense()
    {
        $this->arguments[] = '--dense';
        return $this;
    }

    /**
     * Add the sparse option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function sparse()
    {
        $this->arguments[] = '--sparse';
        return $this;
    }

    /**
     * Add the simplify-merges option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function simplifyMerges()
    {
        $this->arguments[] = '--simplify-merges';
        return $this;
    }

    /**
     * Add the ancestry-path option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function ancestryPath()
    {
        $this->arguments[] = '--ancestry-path';
        return $this;
    }

    /**
     * Add the date-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function dateOrder()
    {
        $this->arguments[] = '--date-order';
        return $this;
    }

    /**
     * Add the author-date-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function authorDateOrder()
    {
        $this->arguments[] = '--author-date-order';
        return $this;
    }

    /**
     * Add the topo-order option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function topoOrder()
    {
        $this->arguments[] = '--topo-order';
        return $this;
    }

    /**
     * Add the reverse option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function reverse()
    {
        $this->arguments[] = '--reverse';
        return $this;
    }

    /**
     * Add the objects option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function objects()
    {
        $this->arguments[] = '--objects';
        return $this;
    }

    /**
     * Add the objects-edge option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function objectsEdge()
    {
        $this->arguments[] = '--objects-edge';
        return $this;
    }

    /**
     * Add the unpacked option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function unpacked()
    {
        $this->arguments[] = '--unpacked';
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
        $this->arguments[] = '--no-walk' . ($walk ? '=' . $walk : '');
        return $this;
    }

    /**
     * Add the do-walk option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function doWalk()
    {
        $this->arguments[] = '--do-walk';
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
        $this->arguments[] = '--pretty' . ($format ? '=' . $format : '');
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
        $this->arguments[] = '--format=' . $format;
        return $this;
    }

    /**
     * Add the abbrev-commit option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function abbrevCommit()
    {
        $this->arguments[] = '--abbrev-commit';
        return $this;
    }

    /**
     * Add the no-abbrev-commit option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noAbbrevCommit()
    {
        $this->arguments[] = '--no-abbrev-commit';
        return $this;
    }

    /**
     * Add the oneline option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function oneline()
    {
        $this->arguments[] = '--oneline';
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
        $this->arguments[] = '--encoding=' . $encoding;
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
        $this->arguments[] = '--notes' . ($ref ? '=' . $ref : '');
        return $this;
    }

    /**
     * Add the no-notes option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function noNotes()
    {
        $this->arguments[] = '--no-notes';
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
        $this->arguments[] = '--show-notes' . ($ref ? '=' . $ref : '');
        return $this;
    }

    /**
     * Add the show-signature option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function showSignature()
    {
        $this->arguments[] = '--show-signature';
        return $this;
    }

    /**
     * Add the relative-date option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function relativeDate()
    {
        $this->arguments[] = '--relative-date';
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
        $this->arguments[] = '--date=' . $format;
        return $this;
    }

    /**
     * Add the parents option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function parents()
    {
        $this->arguments[] = '--parents';
        return $this;
    }

    /**
     * Add the children option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function children()
    {
        $this->arguments[] = '--children';
        return $this;
    }

    /**
     * Add the left-right option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function leftRight()
    {
        $this->arguments[] = '--left-right';
        return $this;
    }

    /**
     * Add the graph option to the command line.
     *
     * @return LogCommandBuilder
     */
    public function graph()
    {
        $this->arguments[] = '--graph';
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
        $this->arguments[] = '-c';
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
        $this->arguments[] = '--cc';
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
        $this->arguments[] = '-m';
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
        $this->arguments[] = '-r';
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
        $this->arguments[] = '-t';
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
        $args = \func_get_args();
        if (\count($args)) {
            $this->arguments[] = '--';
            foreach ($args as $pathspec) {
                $this->arguments[] = $pathspec;
            }
        }
        return $this->run();
    }
}
