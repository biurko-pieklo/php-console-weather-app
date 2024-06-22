<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use weather\Writer;

final class WriterTest extends TestCase {
    public function testCanFilesBeSaved(): void {
        $this->assertDirectoryIsWritable('output/json');
        $this->assertDirectoryIsWritable('output/pdf');
        $this->assertDirectoryIsWritable('output/xml');
    }

    public function testWriterPdfFunctionCannotTakeStringAsArgument(): void {
        $cities = 'Warszawa, temperature:20oC';
        $this->expectException(TypeError::class);
        Writer::toPDF($cities);
    }

    public function testWriterJsonFunctionCannotTakeStringAsArgument(): void {
        $cities = 'Warszawa, temperature:20oC';
        $this->expectException(TypeError::class);
        Writer::toJSON($cities);
    }

    public function testWriterXmlFunctionCannotTakeStringAsArgument(): void {
        $cities = 'Warszawa, temperature:20oC';
        $this->expectException(TypeError::class);
        Writer::toXML($cities);
    }
}
