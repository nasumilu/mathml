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
 */
class ParseException extends InvalidArgumentException
{

    
    public static function unexpectedNode(string $expectedNode, SimpleXMLElement|string $node): self 
    {
        $invalidNode = is_string($node) ? $node : $node->getName();
        $msg = "Expected $expectedNode element(s), found $invalidNode!";
        return new self($msg);
    }
    
    public static function notNumericValue(string $value): self 
    {
        $msg = "Expected a numeric value, found $value!";
        throw new self($msg);
    }
    
    public static function notValidOperator(string $value, string ...$allowedOperators): self
    {
        
        $msg = 'Expected operator %s, found %s!';
        throw new self(sprintf($msg, implode('|', $allowedOperators), $value));
    }
        
    
}
