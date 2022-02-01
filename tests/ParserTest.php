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

namespace Nasumilu\MathML\Tests;

use PHPUnit\Framework\TestCase;
use Nasumilu\MathML\Parser;
use Nasumilu\MathML\ParseException;

/**
 * Description of Parser
 *
 * @author mlucas
 */
class ParserTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function add(): void
    {
        $this->assertEquals(1.56, Parser::calculateFromFile(__DIR__ . '/Resources/valid.xml'));
    }

    /**
     * @test
     * @return void
     */
    public function nonNumericValue(): void
    {
        $this->expectException(ParseException::class);
        $xml = "<math><mrow><mn>1</mn><mo>+</mo><mn>t</mn></mrow></math>";
        Parser::calculate($xml);
    }

    /**
     * @test
     * @return void
     */
    public function invalidOperator(): void
    {
        $this->expectException(ParseException::class);
        $xml = "<math><mrow><mn>1</mn><mo>^</mo><mn>t</mn></mrow></math>";
        Parser::calculate($xml);
    }

    /**
     * @test
     * @return void
     */
    public function unexpectedNodeMRow(): void
    {
        $this->expectException(ParseException::class);
        $xml = "<math><mn>1</mn><mo>+</mo><mn>t</mn></math>";
        Parser::calculate($xml);
    }

    /**
     * @test
     * @return void
     */
    public function unexpectedNodeNotMnOrMo(): void
    {
        $this->expectException(ParseException::class);
        $xml = "<math><mrow><mn>1</mn><mo>+</mo><mi>i</mi></mrow></math>";
        Parser::calculate($xml);
    }

}
