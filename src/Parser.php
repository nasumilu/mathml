<?php

/*
 * Copyright 2022 mlucas.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Nasumilu\MathML;

use SimpleXMLElement;
use InvalidArgumentException;

/**
 *
 * @author Michael Lucas <nasumilu@gmail.com>
 */
class Parser
{

    private const OPERATORS = ['(', ')', '/', '÷', '*', '×', '-', '+'];

    private function __construct()
    {
        
    }

    public static function calculateFromFile(string $filename): int|float
    {
        return static::calculate(simplexml_load_file($filename));
    }

    public static function calculate(string|SimpleXMLElement $xml): int|float
    {
        if (is_string($xml)) {
            $xml = new SimpleXMLElement($xml);
        }

        return static::calculateResults($xml->mrow);
    }

    private static function calculateResults(SimpleXMLElement $node): int|float
    {
        $equation = '$results = ';
        foreach ($node->children() as $value) {
            $equation .= static::normalizeNode($value);
        }
        eval($equation . ';');
        return $results;
    }

    private static function normalizeNode(SimpleXMLElement $node): string
    {
        $name = $node->getName();
        $value = (string) $node;

        if ($name !== 'mo' && $name !== 'mn') {
            throw new InvalidArgumentException("Expected either mn or mo, "
                            . "found $name!");
        } else if ('mn' === $name && !is_numeric($value)) {
            throw new InvalidArgumentException("Expected a numeric value, "
                            . "found $value!");
        } else if ('mo' === $name && !in_array($value, static::OPERATORS)) {
            throw new InvalidArgumentException(
                            vsprintf('Expected operator `%s`, `%s`, `%s`, '
                                    . '`%s`, `%s`, `%s`,`%s`, or `%s`, found'
                                    . ' `%s`!',
                                    array_merge(static::OPERATORS, [$value])));
        }

        if ('÷' === $value) {
            $value = '/';
        } else if ('×' === $value) {
            $value = '*';
        }
        
        return $value;
    }

}
