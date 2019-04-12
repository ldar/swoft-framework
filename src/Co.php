<?php declare(strict_types=1);

namespace Swoft;

use Swoft\Context\Context;
use Swoft\Stdlib\Helper\PhpHelper;
use Swoole\Coroutine;

/**
 * Class Co
 * @since   2.0
 */
class Co
{
    /**
     * Coroutine id mapping
     *
     * @var array
     * @example
     * [
     *    'child id'  => 'top id',
     *    'child id'  => 'top id',
     *    'child id'  => 'top id'
     * ]
     */
    private static $mapping = [];

    /**
     * Get current coroutine id
     *
     * @return int
     * -1   Not in coroutine
     * > -1 In coroutine
     */
    public static function id(): int
    {
        return Coroutine::getCid();
    }

    /**
     * Get the top coroutine ID
     *
     * @return int
     */
    public static function tid(): int
    {
        $id = self::id();
        return self::$mapping[$id] ?? $id;
    }

    /**
     * Create coroutine
     *
     * @param callable $callable
     * @param bool     $wait
     *
     * @return int If success, return coID
     */
    public static function create(callable $callable, bool $wait = true): int
    {
        $tid = self::tid();

        // return coroutine ID for created.
        return \go(function () use ($callable, $tid, $wait) {
            try {
                $id = Coroutine::getCid();
                // Storage fd
                self::$mapping[$id] = $tid;

                if ($wait) {
                    Context::getWaitGroup()->add();
                }

                PhpHelper::call($callable);
            } catch (\Throwable $e) {
                \printf(
                    "Coroutine Exception: %s\nAt File %s line %d\nTrace:\n%s",
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine(),
                    $e->getTraceAsString()
                );
            }

            if ($wait) {
                // Trigger defer
                \Swoft::trigger(SwoftEvent::COROUTINE_DEFER);

                Context::getWaitGroup()->done();
            }
        });
    }

    /**
     * Write file
     *
     * @param string   $filename
     * @param string   $data
     * @param int|null $flags
     *
     * @return int
     */
    public static function writeFile(string $filename, string $data, int $flags = null): int
    {
        return Coroutine::writeFile($filename, $data, $flags);
    }
}
