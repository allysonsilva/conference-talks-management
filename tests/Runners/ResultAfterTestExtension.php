<?php

namespace Tests\Runners;

use PDO;
use Throwable;
use PHPUnit\Runner\AfterTestHook;

final class ResultAfterTestExtension implements AfterTestHook
{
    protected PDO $connection;

    protected string $table = 'tests_execution';

    public function __construct()
    {
        try {
            $this->connection = new PDO('sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database.sqlite');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Throwable $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * This hook will fire after any test, regardless of the result.
     *
     * @param string $test
     * @param float $time
     *
     * @return void
     */
    public function executeAfterTest(string $test, float $time): void
    {
        try {
            $this->insertRecord($test, $time);
        } catch (Throwable $exception) {
            dd($exception->getMessage());
        }
    }

    protected function insertRecord(string $test, float $time): void
    {
        [$class, $method] = explode('::', $test);

        // phpcs:disable ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine
        $this->connection
             ->prepare(
                 <<<EOT
                    INSERT INTO `{$this->table}` (time, test, method, class, created_at, updated_at)
                    VALUES (:time, :test, :method, :class, :created_at, :updated_at)
                    ON CONFLICT (test) DO UPDATE SET time = :time, updated_at = :updated_at;
                 EOT
             )
             ->execute([
                'time' => $time,
                'test' => $test,
                'method' => $method,
                'class' => $class,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
             ]);
    }
}
