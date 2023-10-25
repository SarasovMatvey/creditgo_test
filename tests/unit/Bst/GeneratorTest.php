<?php

namespace unit\Bst;

use App\Bst\DataProvider;
use App\Bst\Generator;
use App\Bst\Row;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testGenerateIntegers()
    {
        $dataProviderMock = $this->createMock(DataProvider::class);
        $dataProviderMock
            ->expects($this->once())
            ->method('provideData')
            ->willReturn($this->fakeData([2, 7, 5, 4, 3, 6, 1]));

        $generator = new Generator($dataProviderMock, 'test');

        $expectedOutput = json_decode(file_get_contents(__DIR__ . '/fixtures/output_ints.txt'), true);
        $this->assertEquals($expectedOutput, $generator->generate()->toArray());
    }

    public function testGenerateStrings()
    {
        $dataProviderMock = $this->createMock(DataProvider::class);
        $dataProviderMock
            ->expects($this->once())
            ->method('provideData')
            ->willReturn($this->fakeData(['John', 'Bob', 'Tom', 'Alan', 'Ellen', 'Karen', 'Wendy']));

        $generator = new Generator($dataProviderMock, 'test');

        $expectedOutput = json_decode(file_get_contents(__DIR__ . '/fixtures/output_strs.txt'), true);
        $this->assertEquals($expectedOutput, $generator->generate()->toArray());
    }

    public function testGenerateWithEmptyData()
    {
        $dataProviderMock = $this->createMock(DataProvider::class);
        $dataProviderMock
            ->expects($this->once())
            ->method('provideData')
            ->willReturn($this->fakeData([]));

        $generator = new Generator($dataProviderMock, 'test');

        $this->assertNull($generator->generate());
    }


    public function testGenerateRowWithMissedField()
    {
        $dataProviderMock = $this->createMock(DataProvider::class);
        $dataProviderMock
            ->expects($this->once())
            ->method('provideData')
            ->willReturn($this->fakeDataWithMissedField());

        $generator = new Generator($dataProviderMock, 'test');

        $expectedOutput = json_decode(file_get_contents(__DIR__ . '/fixtures/output_missed.txt'), true);
        $this->assertEquals($expectedOutput, $generator->generate()->toArray());
    }

    protected function fakeData(array $values): array {
        return array_map(function ($item) {
            $rowMock = $this->createMock(Row::class);
            $rowMock->expects($this->any())
                ->method('getFieldValue')
                ->willReturn($item);
            $rowMock->expects($this->once())
                ->method('hasField')
                ->willReturn(true);

            return $rowMock;

        }, $values);
    }

    protected function fakeDataWithMissedField(): array {
        $values = [2, 7, 5, null, 3, 6, 1];

        return array_map(function ($item) {
            $rowMock = $this->createMock(Row::class);

            if (is_null($item)) {
                $rowMock->expects($this->any())
                    ->method('getFieldValue')
                    ->willReturn(null);
                $rowMock->expects($this->any())
                    ->method('hasField')
                    ->willReturn(false);
            } else {
                $rowMock->expects($this->any())
                    ->method('getFieldValue')
                    ->willReturn($item);
                $rowMock->expects($this->once())
                    ->method('hasField')
                    ->willReturn(true);
            }

            return $rowMock;

        }, $values);
    }
}
