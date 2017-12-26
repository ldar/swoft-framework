<?php

namespace Swoft\Testing\Aop;

use Swoft\Aop\ProceedingJoinPoint;
use Swoft\Bean\Annotation\After;
use Swoft\Bean\Annotation\AfterReturning;
use Swoft\Bean\Annotation\AfterThrowing;
use Swoft\Bean\Annotation\Around;
use Swoft\Bean\Annotation\Aspect;
use Swoft\Bean\Annotation\Before;
use Swoft\Bean\Annotation\PointBean;

/**
 * the test of aspcet
 *
 * @Aspect()
 * @PointBean(
 *     include={AopBean::class},
 * )
 *
 * @uses      AllPointAspect
 * @version   2017年12月24日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class AllPointAspect
{
    /**
     * @Before()
     */
    public function before()
    {
        echo "aop=1 before !\n";
    }

    /**
     * @After()
     */
    public function after()
    {
        echo "aop=1 after !\n";
    }

    /**
     * @AfterReturning()
     */
    public function afterReturn()
    {
        echo "aop=1 afterReturn !\n";
    }

    /**
     * @Around()
     * @param ProceedingJoinPoint $proceedingJoinPoint
     */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
        echo "aop=1 around before !\n";
        $result = $proceedingJoinPoint->proceed();
        echo "aop=1 around after !\n";
        return $result;
    }

    /**
     * @AfterThrowing()
     */
    public function afterThrowing()
    {
        echo "aop=1 afterThrowing !\n";
    }
}