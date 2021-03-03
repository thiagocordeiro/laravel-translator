<?php declare(strict_types=1);

namespace Tests\Unit\Translator\Framework;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    private string $testDir;

    protected function setUp(): void
    {
        $this->testDir = realpath(__DIR__ . '/../..') ?? '';
    }

    public function testGlobRecursive(): void
    {
        $fixturesDir = realpath("{$this->testDir}/Fixtures/Glob");

        $files = glob_recursive("{$fixturesDir}/*.txt", GLOB_BRACE);

        $this->assertEquals([
            '/Fixtures/Glob/file1.txt',
            '/Fixtures/Glob/file2.txt',
            '/Fixtures/Glob/SubDir/SubDirFile1.txt',
            '/Fixtures/Glob/SubDir/SubDirFile2.txt',
            '/Fixtures/Glob/SubDir/SubDir2/SubDir2file1.txt',
            '/Fixtures/Glob/SubDir/SubDir2/SubDir2file2.txt',
        ], $this->replaceDirectorySeparators($this->removeRelativePath($files)));
    }

    /**
     * @param string[] $files
     * @return string[]
     */
    private function removeRelativePath(array $files): array
    {
        return array_map(fn (string $file): string => str_replace($this->testDir, '', $file), $files);
    }

    /**
     * @param string[] $files
     * @return string[]
     */
    private function replaceDirectorySeparators(array $files): array
    {
        return array_map(fn (string $file): string => str_replace('\\', '/', $file), $files);
    }
}
