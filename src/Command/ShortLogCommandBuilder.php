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
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2018 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Command;

/**
 * ShortLog command builder.
 */
class ShortLogCommandBuilder implements CommandBuilderInterface
{
    use CommandBuilderTrait;

    /**
     * {@inheritDoc}
     */
    protected function initializeProcessBuilder()
    {
        $this->arguments[] = 'shortlog';
    }

    /**
     * Add the  option to the command line.
     *
     * @return ShortLogCommandBuilder
     */
    public function numbered()
    {
        $this->arguments[] = '--numbered';

        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @return ShortLogCommandBuilder
     */
    public function summary()
    {
        $this->arguments[] = '--summary';

        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @return ShortLogCommandBuilder
     */
    public function email()
    {
        $this->arguments[] = '--email';

        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @param string $format The format.
     *
     * @return ShortLogCommandBuilder
     */
    public function format($format)
    {
        $this->arguments[] = '--format=' . $format;

        return $this;
    }

    /**
     * Add the  option to the command line.
     *
     * @param string $revisionRange The revision range.
     *
     * @return ShortLogCommandBuilder
     */
    public function revisionRange($revisionRange)
    {
        $this->arguments[] = $revisionRange;

        return $this;
    }

    /**
     * Linewrap the output by wrapping each line at width.
     *
     * The first line of each entry is indented by indent1 spaces, and the second and subsequent lines are indented by
     * indent2 spaces.
     *
     * Width, indent1, and indent2 default to 76, 6 and 9 respectively.
     *
     * If width is 0 (zero) then indent the lines of the output without wrapping them.
     *
     * @param int      $width   The width or 0 to disable indenting.
     *
     * @param null|int $indent1 The amount of spaces the first line of each entry is indented by.
     *
     * @param null|int $indent2 The amount of spaces subsequent lines of each entry are indented by.
     *
     * @return ShortLogCommandBuilder
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function w($width, $indent1 = null, $indent2 = null)
    {
        if ($indent1) {
            $width .= ',' . $indent1;

            if ($indent2) {
                $width .= ',' . $indent2;
            }
        }

        $this->arguments[] = '-w' . $width;

        return $this;
    }

    /**
     * Execute the command and return the result.
     *
     * @param null|string $pathSpec Optional path spec.
     *
     * @param null|string $_        Optional list of more path specs.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     */
    public function execute($pathSpec = null, $_ = null)
    {
        /** @var list<string> $args */
        $args = \func_get_args();
        if (\count($args)) {
            $this->arguments[] = '--';
            foreach ($args as $pathSpec) {
                $this->arguments[] = $pathSpec;
            }
        }

        return (string) $this->run();
    }
}
