<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Traits\GeneratesTestDirectory;

class InitScriptTest extends TestCase
{
    use GeneratesTestDirectory;

    /**
     * Copies init.sh and resources directory to the temporal directory.
     */
    public function setUp(): void
    {
        $projectDirectory = __DIR__ . '/..';

        exec("cp {$projectDirectory}/init.sh " . self::$testDirectory);
        exec("cp -r {$projectDirectory}/resources " . self::$testDirectory);
    }

    /** @test */
    public function it_displays_a_success_message()
    {
        $output = exec('bash init.sh');

        $this->assertEquals('Devweb initialized!', $output);
    }

    /** @test */
    public function it_creates_a_yaml_file()
    {
        exec('bash init.sh');

        $this->assertFileExists(self::$testDirectory . '/Devweb.yaml');
    }

    /** @test */
    public function it_creates_a_json_file_if_requested()
    {
        exec('bash init.sh json');

        $this->assertFileExists(self::$testDirectory . '/Devweb.json');
    }

    /** @test */
    public function it_creates_an_after_shell_script()
    {
        exec('bash init.sh');

        $this->assertFileExists(self::$testDirectory . '/after.sh');
    }

    /** @test */
    public function it_creates_an_aliases_file()
    {
        exec('bash init.sh');

        $this->assertFileExists(self::$testDirectory . '/aliases');
    }
}
