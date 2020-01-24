<?php

namespace Tests\Unit\Interfaces\API\Rules;

use PHPUnit\Framework\TestCase;
use App\API\Conference\Rules\TalkTitleRule;
use Illuminate\Contracts\Validation\ImplicitRule;

class TalkTitleRuleTest extends TestCase
{
    protected TalkTitleRule $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = (new TalkTitleRule());
    }

    /**
     * @testdox Check if rule is InstanceOf ImplicitRule::class
     */
    public function testTalkTitleRule(): void
    {
        self::assertInstanceOf(ImplicitRule::class, $this->rule);
    }

    /**
     * @testdox Check that the talk title passes
     * @dataProvider validTalksTitlesProvider
     */
    public function testTalkTitlePass(string $title): void
    {
        self::assertTrue($this->rule->passes('title', $title));
    }

    /**
     * @testdox Check that the talk title fail
     * @dataProvider invalidTalksTitlesProvider
     */
    public function testTalkTitleFail(string $title): void
    {
        self::assertFalse($this->rule->passes('title', $title));
    }

    public function validTalksTitlesProvider(): array
    {
        return [
            'cacilds vidis litro abertis 2min' => ['cacilds vidis litro abertis 2min'],
            '1min Tá deprimidis, eu conheço uma cachacis que pode alegrar sua vidis' => ['1min Tá deprimidis, eu conheço uma cachacis que pode alegrar sua vidis'],
            'Atirei o pau no 1min gatis, per gatis num morreus' => ['Atirei o pau no 1min gatis, per gatis num morreus'],
            'Quem manda na minha terra sou euzis! lightning' => ['Quem manda na minha terra sou euzis! lightning'],
            'Mais vale um bebadis lightning conhecidiss, que um alcoolatra anonimis.' => ['Mais vale um bebadis lightning conhecidiss, que um alcoolatra anonimis.'],
        ];
    }

    public function invalidTalksTitlesProvider(): array
    {
        return [
            'cacilds vidis litro abertis' => ['cacilds vidis litro abertis'],
            'Quem manda na minha terra sou euzis!' => ['Quem manda na minha terra sou euzis!'],
            '1min Tá deprimidis, 111 eu conheço uma 222 cachacis que pode alegrar sua vidis' => ['1min Tá deprimidis, 111 eu conheço uma 222 cachacis que pode alegrar sua vidis'],
            'Atirei o pau no 1min 2min gatis, per gatis num morreus' => ['Atirei o pau no 1min 2min gatis, per gatis num morreus'],
        ];
    }
}
