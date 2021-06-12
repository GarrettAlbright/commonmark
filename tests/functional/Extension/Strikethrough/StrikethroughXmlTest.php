<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Tests\Functional\Extension\Strikethrough;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Tests\Functional\AbstractLocalDataTest;
use League\CommonMark\Xml\XmlRenderer;

final class StrikethroughXmlTest extends AbstractLocalDataTest
{
    /** @var MarkdownParser */
    private $parser;

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new StrikethroughExtension());

        $this->parser    = new MarkdownParser($environment);
        $this->converter = new XmlRenderer($environment);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testRenderer(string $markdown, string $expectedXml, string $testName): void
    {
        $document = $this->parser->parse($markdown);

        $this->assertSame($expectedXml, $this->converter->renderDocument($document)->getContent(), \sprintf('Unexpected result for "%s" test', $testName));
    }

    /**
     * @return iterable<string, string, string>
     */
    public function dataProvider(): iterable
    {
        foreach ($this->loadTests(__DIR__ . '/xml', '*', '.md', '.xml') as $test) {
            yield $test;
        }
    }
}
