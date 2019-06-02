<?php
/*
 * Project: webgeeker-rest
 * File: ValidationTest.php
 * CreateTime: 2017/4/2 11:51
 * Author: photondragon
 * Email: photondragon@163.com
 */
/**
 * @file ValidationTest.php
 * @brief brief description
 *
 * elaborate description
 */

namespace WebGeeker\RestTest;

use PHPUnit\Framework\TestCase;
use \WebGeeker\Validation\Validation;
use WebGeeker\ValidationTest\MyValidation;
use WebGeeker\ValidationTest\MyValidation2;

/**
 * @class ValidationTest
 * @brief brief description
 *
 * elaborate description
 */
class ValidationTest extends TestCase
{
    // $callback必须抛出异常
    private function _assertThrowExpection(callable $callback, $message = '')
    {
        if (is_callable($callback) === false)
            throw new \Exception("\$callback不是可执行函数");
        try {
            $callback();
            $ret = true;
        } catch (\Exception $e) {
            $ret = false;
        }
        $this->assertFalse($ret, $message);
    }

    private function _assertThrowExpectionContainErrorString(callable $callback, $containedErroString = '')
    {
        try {
            throw new \Exception("这里抛出异常, 然后捕获它, 以便在调用栈中找出当前函数的调用代码所在的行");
        } catch (\Exception $e) {
            $callLine = $e->getTrace()[0]['line'];
        }

        if (is_callable($callback) === false)
            throw new \Exception("\$callback不是可执行函数");
        try {
            $callback();
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            if (strpos($errstr, $containedErroString) === false)
                throw new \Exception("Line $callLine: 这里抛出的异常中应该包含字符串“${containedErroString}”\n\t实际抛出的异常是“${errstr}”");
            return;
        }
        throw new \Exception("Line $callLine: 这里应该抛出异常");
    }

    public function testValidateRequired()
    {
        $params = [
            'name' => "WebGeeker",
        ];

        Validation::validate($params, ['name' => 'Required']);
        Validation::validate($params, ['name' => 'Required|Alias:姓名']);
        Validation::validate($params, ['name' => 'Required|>>>:必须提供姓名']);
        Validation::validate($params, ['name' => 'Required|StrLenGeLe:1,20']);
        Validation::validate($params, ['name' => 'Required|StrLenGeLe:1,20|Alias:姓名']);
        Validation::validate($params, ['name' => 'Required|StrLenGeLe:1,20|>>>:必须提供姓名']);

        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required']);
        }, '必须提供“phone”');
        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required|Alias:电话']);
        }, '必须提供“电话”');
        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required|>>>:必须提供电话']);
        }, '必须提供电话');
        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required|StrLen:11']);
        }, '必须提供“phone”');
        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required|StrLen:11|Alias:电话']);
        }, '必须提供“电话”');
        $this->_assertThrowExpectionContainErrorString(function () use ($params) {
            Validation::validate($params, ['phone' => 'Required|StrLen:11|>>>:必须提供电话']);
        }, '必须提供电话');
    }

    public function testValidateInt()
    {
        // Int
        Validation::validate(['varInt' => '-1'], ['varInt' => 'Int']);
        Validation::validate(['varInt' => '0'], ['varInt' => 'Int']);
        Validation::validate(['varInt' => '1'], ['varInt' => 'Int']);
        Validation::validate(['varInt' => -1], ['varInt' => 'Int']);
        Validation::validate(['varInt' => 0], ['varInt' => 'Int']);
        Validation::validate(['varInt' => 1], ['varInt' => 'Int']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => true], ['varInt' => 'Int']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => []], ['varInt' => 'Int']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 0.0], ['varInt' => 'Int']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'Int']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => ''], ['varInt' => 'Int']);
        }, '必须是整数');

        // IntEq
        Validation::validate(['varInt' => '-1'], ['varInt' => 'IntEq:-1']);
        Validation::validate(['varInt' => -1], ['varInt' => 'IntEq:-1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntEq:-1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => true], ['varInt' => 'IntEq:-1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '0'], ['varInt' => 'IntEq:-1']);
        }, '必须等于 -1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 0], ['varInt' => 'IntEq:-1']);
        }, '必须等于 -1');

        // IntGt
        Validation::validate(['varInt' => '1'], ['varInt' => 'IntGt:0']);
        Validation::validate(['varInt' => 1], ['varInt' => 'IntGt:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGt:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => 1.0], ['varInt' => 'IntGt:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '0'], ['varInt' => 'IntGt:0']);
        }, '必须大于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 0], ['varInt' => 'IntGt:0']);
        }, '必须大于 0');

        // IntGe
        Validation::validate(['varInt' => '1'], ['varInt' => 'IntGe:0']);
        Validation::validate(['varInt' => 1], ['varInt' => 'IntGe:0']);
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntGe:0']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntGe:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGe:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => []], ['varInt' => 'IntGe:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '-1'], ['varInt' => 'IntGe:0']);
        }, '必须大于等于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => -1], ['varInt' => 'IntGe:0']);
        }, '必须大于等于 0');

        // IntLt
        Validation::validate(['varInt' => '-1'], ['varInt' => 'IntLt:0']);
        Validation::validate(['varInt' => -1], ['varInt' => 'IntLt:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntLt:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => 1.0], ['varInt' => 'IntLt:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '0'], ['varInt' => 'IntLt:0']);
        }, '必须小于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 0], ['varInt' => 'IntLt:0']);
        }, '必须小于 0');

        // IntLe
        Validation::validate(['varInt' => '-1'], ['varInt' => 'IntLe:0']);
        Validation::validate(['varInt' => -1], ['varInt' => 'IntLe:0']);
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntLe:0']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntLe:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntLe:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => false], ['varInt' => 'IntLe:0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '1'], ['varInt' => 'IntLe:0']);
        }, '必须小于等于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 1], ['varInt' => 'IntLe:0']);
        }, '必须小于等于 0');

        // IntGeLe
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntGeLe:0,0']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntGeLe:0,0']);
        Validation::validate(['varInt' => '11'], ['varInt' => 'IntGeLe:-100,100']);
        Validation::validate(['varInt' => 11], ['varInt' => 'IntGeLe:-100,100']);
        Validation::validate(['varInt' => '0123'], ['varInt' => 'IntGeLe:123,123']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGeLe:0,0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => 1.0], ['varInt' => 'IntGeLe:0,0']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '-1'], ['varInt' => 'IntGeLe:0,10']);
        }, '必须大于等于 0 小于等于 10');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => -1], ['varInt' => 'IntGeLe:0,10']);
        }, '必须大于等于 0 小于等于 10');

        // IntGtLt
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntGtLt:-1,1']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntGtLt:-1,1']);
        Validation::validate(['varInt' => '000'], ['varInt' => 'IntGtLt:-1,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGtLt:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => 1.0], ['varInt' => 'IntGtLt:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '-1'], ['varInt' => 'IntGtLt:-1,1']);
        }, '必须大于 -1 小于 1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 1], ['varInt' => 'IntGtLt:-1,1']);
        }, '必须大于 -1 小于 1');

        // IntGtLe
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntGtLe:-1,1']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntGtLe:-1,1']);
        Validation::validate(['varInt' => '1'], ['varInt' => 'IntGtLe:-1,1']);
        Validation::validate(['varInt' => 1], ['varInt' => 'IntGtLe:-1,1']);
        Validation::validate(['varInt' => '001'], ['varInt' => 'IntGtLe:-1,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGtLe:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => 1.0], ['varInt' => 'IntGtLe:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '-1'], ['varInt' => 'IntGtLe:-1,1']);
        }, '必须大于 -1 小于等于 1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 2], ['varInt' => 'IntGtLe:-1,1']);
        }, '必须大于 -1 小于等于 1');

        // IntGeLt
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntGeLt:-1,1']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntGeLt:-1,1']);
        Validation::validate(['varInt' => '-1'], ['varInt' => 'IntGeLt:-1,1']);
        Validation::validate(['varInt' => -1], ['varInt' => 'IntGeLt:-1,1']);
        Validation::validate(['varInt' => '-001'], ['varInt' => 'IntGeLt:-1,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntGeLt:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => -1.0], ['varInt' => 'IntGeLt:-1,1']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '-2'], ['varInt' => 'IntGeLt:-1,1']);
        }, '必须大于等于 -1 小于 1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 1], ['varInt' => 'IntGeLt:-1,1']);
        }, '必须大于等于 -1 小于 1');

        // IntIn
        Validation::validate(['varInt' => '1'], ['varInt' => 'IntIn:1,2,3']);
        Validation::validate(['varInt' => 1], ['varInt' => 'IntIn:1,2,3']);
        Validation::validate(['varInt' => '02'], ['varInt' => 'IntIn:1,2,3']);
        Validation::validate(['varInt' => 2], ['varInt' => 'IntIn:1,2,3']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntIn:1,2,3']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => -1.0], ['varInt' => 'IntIn:1,2,3']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '0'], ['varInt' => 'IntIn:1,2,3']);
        }, '只能取这些值: 1, 2, 3');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 5], ['varInt' => 'IntIn:1,2,3']);
        }, '只能取这些值: 1, 2, 3');

        // IntNotIn
        Validation::validate(['varInt' => '0'], ['varInt' => 'IntNotIn:1,2,3']);
        Validation::validate(['varInt' => 0], ['varInt' => 'IntNotIn:1,2,3']);
        Validation::validate(['varInt' => '04'], ['varInt' => 'IntNotIn:1,2,3']);
        Validation::validate(['varInt' => 4], ['varInt' => 'IntNotIn:1,2,3']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varInt' => 'abc'], ['varInt' => 'IntNotIn:1,2,3']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varInt' => -1.0], ['varInt' => 'IntNotIn:1,2,3']);
        }, '必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => '1'], ['varInt' => 'IntNotIn:1,2,3']);
        }, '不能取这些值: 1, 2, 3');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varInt' => 2], ['varInt' => 'IntNotIn:1,2,3']);
        }, '不能取这些值: 1, 2, 3');

    }

    public function testValidateFloat()
    {
        // Float
        Validation::validate(['varFloat' => '-1'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => '1'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => '-1.0'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => '1.0'], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => -1.0], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => 1.0], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => -1], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'Float']);
        Validation::validate(['varFloat' => 1], ['varFloat' => 'Float']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => true], ['varFloat' => 'Float']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => []], ['varFloat' => 'Float']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'Float']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => ''], ['varFloat' => 'Float']);
        }, '必须是浮点数');

        // FloatGt
        Validation::validate(['varFloat' => '1'], ['varFloat' => 'FloatGt:0.0']);
        Validation::validate(['varFloat' => '1.0'], ['varFloat' => 'FloatGt:0.0']);
        Validation::validate(['varFloat' => 1.0], ['varFloat' => 'FloatGt:0']);
        Validation::validate(['varFloat' => 0.1], ['varFloat' => 'FloatGt:0.0']);
        Validation::validate(['varFloat' => 1], ['varFloat' => 'FloatGt:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatGt:0.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => true], ['varFloat' => 'FloatGt:0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGt:0.0']);
        }, '必须大于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGt:0']);
        }, '必须大于 0');

        // FloatGe
        Validation::validate(['varFloat' => '1'], ['varFloat' => 'FloatGe:0.0']);
        Validation::validate(['varFloat' => '1.0'], ['varFloat' => 'FloatGe:0.0']);
        Validation::validate(['varFloat' => 1.0], ['varFloat' => 'FloatGe:0']);
        Validation::validate(['varFloat' => 1], ['varFloat' => 'FloatGe:0']);
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatGe:0.0']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGe:0.0']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGe:0']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatGe:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatGe:0.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => []], ['varFloat' => 'FloatGe:0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '-1'], ['varFloat' => 'FloatGe:0.0']);
        }, '必须大于等于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => -0.1], ['varFloat' => 'FloatGe:0']);
        }, '必须大于等于 0');

        // FloatLt
        Validation::validate(['varFloat' => '-1'], ['varFloat' => 'FloatLt:0.0']);
        Validation::validate(['varFloat' => -1], ['varFloat' => 'FloatLt:0.0']);
        Validation::validate(['varFloat' => '-0.1'], ['varFloat' => 'FloatLt:0.0']);
        Validation::validate(['varFloat' => -0.1], ['varFloat' => 'FloatLt:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatLt:0.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => true], ['varFloat' => 'FloatLt:0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatLt:0.0']);
        }, '必须小于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatLt:0']);
        }, '必须小于 0');

        // FloatLe
        Validation::validate(['varFloat' => '-1'], ['varFloat' => 'FloatLe:0.0']);
        Validation::validate(['varFloat' => -1], ['varFloat' => 'FloatLe:0.0']);
        Validation::validate(['varFloat' => '-0.1'], ['varFloat' => 'FloatLe:0.0']);
        Validation::validate(['varFloat' => -0.1], ['varFloat' => 'FloatLe:0']);
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatLe:0.0']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatLe:0.0']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatLe:0']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatLe:0']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatLe:0.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => false], ['varFloat' => 'FloatLe:0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '0.1'], ['varFloat' => 'FloatLe:0.0']);
        }, '必须小于等于 0');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 0.1], ['varFloat' => 'FloatLe:0']);
        }, '必须小于等于 0');

        // FloatGeLe
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatGeLe:0.0,0']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGeLe:0.0,0']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGeLe:0,0.0']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatGeLe:0,0.0']);
        Validation::validate(['varFloat' => '11'], ['varFloat' => 'FloatGeLe:-100.0,100']);
        Validation::validate(['varFloat' => '11.0'], ['varFloat' => 'FloatGeLe:-100.0,100']);
        Validation::validate(['varFloat' => 11.0], ['varFloat' => 'FloatGeLe:-100,100.0']);
        Validation::validate(['varFloat' => 11], ['varFloat' => 'FloatGeLe:-100,100.0']);
        Validation::validate(['varFloat' => '0123'], ['varFloat' => 'FloatGeLe:123.0,123']);
        Validation::validate(['varFloat' => '0123.0'], ['varFloat' => 'FloatGeLe:123.0,123']);
        Validation::validate(['varFloat' => 123], ['varFloat' => 'FloatGeLe:123.0,123']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatGeLe:0,0.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => ''], ['varFloat' => 'FloatGeLe:0.0,0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '-0.1'], ['varFloat' => 'FloatGeLe:0,10.0']);
        }, '必须大于等于 0 小于等于 10');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => -0.1], ['varFloat' => 'FloatGeLe:0.0,10.5']);
        }, '必须大于等于 0 小于等于 10.5');

        // FloatGtLt
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatGtLt:-1.0,1']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGtLt:-1.0,1']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGtLt:-1,1.0']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatGtLt:-1,1.0']);
        Validation::validate(['varFloat' => '000'], ['varFloat' => 'FloatGtLt:-1.0,1']);
        Validation::validate(['varFloat' => '00.0'], ['varFloat' => 'FloatGtLt:-1.0,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatGtLt:-1,1.0']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => true], ['varFloat' => 'FloatGtLt:-1.0,1']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '-1'], ['varFloat' => 'FloatGtLt:-1,1.0']);
        }, '必须大于 -1 小于 1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 1.0], ['varFloat' => 'FloatGtLt:-1.0,1']);
        }, '必须大于 -1 小于 1');

        // FloatGtLe
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGtLe:-1,1.5']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatGtLe:-1,1.5']);
        Validation::validate(['varFloat' => '1'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => '1.0'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => 1], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => 1.5], ['varFloat' => 'FloatGtLe:-1,1.5']);
        Validation::validate(['varFloat' => '001'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        Validation::validate(['varFloat' => '00.1'], ['varFloat' => 'FloatGtLe:-1.5,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => ''], ['varFloat' => 'FloatGtLe:-1,1.5']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => true], ['varFloat' => 'FloatGtLe:-1.5,1']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '-1.0'], ['varFloat' => 'FloatGtLe:-1,1.5']);
        }, '必须大于 -1 小于等于 1.5');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => -1.5], ['varFloat' => 'FloatGtLe:-1.5,1']);
        }, '必须大于 -1.5 小于等于 1');

        // FloatGeLt
        Validation::validate(['varFloat' => '0'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        Validation::validate(['varFloat' => '0.0'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        Validation::validate(['varFloat' => 0.0], ['varFloat' => 'FloatGeLt:-1,1.5']);
        Validation::validate(['varFloat' => 0], ['varFloat' => 'FloatGeLt:-1,1.5']);
        Validation::validate(['varFloat' => '-1.5'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        Validation::validate(['varFloat' => -1.0], ['varFloat' => 'FloatGeLt:-1,1.5']);
        Validation::validate(['varFloat' => -1], ['varFloat' => 'FloatGeLt:-1,1.5']);
        Validation::validate(['varFloat' => '-001'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        Validation::validate(['varFloat' => '-001.5'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误1
            Validation::validate(['varFloat' => 'abc'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 类型错误2
            Validation::validate(['varFloat' => false], ['varFloat' => 'FloatGeLt:-1,1.5']);
        }, '必须是浮点数');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => '-1.6'], ['varFloat' => 'FloatGeLt:-1.5,1']);
        }, '必须大于等于 -1.5 小于 1');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['varFloat' => 1.5], ['varFloat' => 'FloatGeLt:-1,1.5']);
        }, '必须大于等于 -1 小于 1.5');

    }

    public function testValidateBool()
    {
        // Bool
        $boolValues = [true, false, 'True', 'faLse'];
        foreach ($boolValues as $boolValue) {
            Validation::validate(['varBool' => $boolValue], ['varBool' => 'Bool']);
        }
        $notBoolValues = [1, 0, '1', '0', 1.0, 'hello', []];
        foreach ($notBoolValues as $notBoolValue) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notBoolValue) {
                Validation::validate(['varBool' => $notBoolValue], ['varBool' => 'Bool']);
            }, '必须是bool型');
        }

        // BoolSmart
        $smartBoolValues = [true, false, 'True', 'faLse', 1, 0, '1', '0', 'Yes', 'no', 'y', 'n'];
        foreach ($smartBoolValues as $smartBoolValue) {
            Validation::validate(['varBool' => $smartBoolValue], ['varBool' => 'BoolSmart']);
        }
        $notSmartBoolValues = [8, '100', 1.0, 0.0, '1.0', '0.0', 'hello', []];
        foreach ($notSmartBoolValues as $notSmartBoolValue) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notSmartBoolValue) {
                Validation::validate(['varBool' => $notSmartBoolValue], ['varBool' => 'BoolSmart']);
            }, '只能取这些值: true, false,');
        }
    }

    public function testValidateStrs()
    {
        // Str
        $strVals = ['', '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Str']);
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Str']);
            }, '必须是字符串');
        }

        // StrEq
        $strVals = ['', '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrEq:'.$strVal]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrEq:'.$strVal.'1']);
            }, '必须等于"');
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrEq:'.$strVal]);
            }, '必须等于"');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrEq:'.$notStrVal]);
            }, '必须是字符串');
        }

        // StrNe
        $strVals = ['', '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNe:'.$strVal.'1']);
        }
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrNe:'.$strVal]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNe:'.$strVal]);
            }, '不能等于"');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrNe:'.$notStrVal]);
            }, '必须是字符串');
        }

        // StrIn
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrIn:'.implode(',',$strVals)]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $strVals) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrIn:'.implode(',',$strVals)]);
            }, '只能取这些值:');
        }
        Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrIn:abc']);
        Validation::validate(['valStr' => ''], ['valStr' => 'StrIn:']);
        Validation::validate(['valStr' => ' '], ['valStr' => 'StrIn: ']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abcd'], ['valStr' => 'StrIn:abc']);
        }, '必须等于"abc"');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => ' '], ['valStr' => 'StrIn:  ']);
        }, '必须等于"  "');
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrIn:Hello']);
            }, '必须是字符串');
        }

        // StrNotIn
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal.'postfix'], ['valStr' => 'StrNotIn:'.implode(',',$strVals)]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $strVals) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNotIn:'.implode(',',$strVals)]);
            }, '不能取这些值:');
        }
        Validation::validate(['valStr' => 'abcd'], ['valStr' => 'StrNotIn:abc']);
        Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrNotIn:']);
        Validation::validate(['valStr' => ''], ['valStr' => 'StrNotIn:abc']);
        Validation::validate(['valStr' => '  '], ['valStr' => 'StrNotIn: ']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrNotIn:abc']);
        }, '不能等于"abc"');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => ''], ['valStr' => 'StrNotIn:']);
        }, '不能等于""');
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrNotIn:Hello']);
            }, '必须是字符串');
        }

        // StrEqI
        $strVals = ['', '123', 'abc', '你好', '-12311112311111', 'Abc', '你a好'];
        $str2Vals = ['', '123', 'abc', '你好', '-12311112311111', 'abC', '你A好'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];
            $str2Val = $str2Vals[$i];
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrEqI:'.$str2Val]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrEqI:'.$strVal.'1']);
            }, '必须等于"');
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrEqI:'.$strVal]);
            }, '"（忽略大小写）');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrEqI:'.$notStrVal]);
            }, '必须是字符串');
        }

        // StrNeI
        $strVals = ['', '123', 'abc', '你好', '-12311112311111', 'Abc', '你a好'];
        $str2Vals = ['', '123', 'abc', '你好', '-12311112311111', 'abC', '你A好'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNeI:'.$strVal.'1']);
        }
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrNeI:'.$strVal]);
        }
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];
            $str2Val = $str2Vals[$i];
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $str2Val) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNeI:'.$str2Val]);
            }, '不能等于"');
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $str2Val) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNeI:'.$str2Val]);
            }, '"（忽略大小写）');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrNeI:'.$notStrVal]);
            }, '必须是字符串');
        }

        // StrInI
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111', 'Abcd', '你a好'];
        $str2Vals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111', 'abCd', '你A好'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrInI:'.implode(',',$str2Vals)]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $strVals) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrInI:'.implode(',',$strVals)]);
            }, '只能取这些值:');
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $strVals) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrInI:'.implode('1,',$strVals).'1']);
            }, '（忽略大小写）');
        }
        Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrInI:Abc']);
        Validation::validate(['valStr' => ''], ['valStr' => 'StrInI:']);
        Validation::validate(['valStr' => ' '], ['valStr' => 'StrInI: ']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abcd'], ['valStr' => 'StrInI:abc']);
        }, '必须等于"abc"');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => ' '], ['valStr' => 'StrInI:  ']);
        }, '必须等于"  "');
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrInI:Hello']);
            }, '必须是字符串');
        }

        // StrNotInI
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111', 'Abcd', '你a好'];
        $str2Vals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111', 'abCd', '你A好'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal.'postfix'], ['valStr' => 'StrNotInI:'.implode(',',$strVals)]);
        }
        foreach ($strVals as $strVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal, $str2Vals) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrNotInI:'.implode(',',$str2Vals)]);
            }, '不能取这些值:');
        }
        Validation::validate(['valStr' => 'abcd'], ['valStr' => 'StrNotInI:abc']);
        Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrNotInI:']);
        Validation::validate(['valStr' => ''], ['valStr' => 'StrNotInI:abc']);
        Validation::validate(['valStr' => '  '], ['valStr' => 'StrNotInI: ']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrNotInI:Abc']);
        }, '不能等于"Abc"');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abc'], ['valStr' => 'StrNotInI:Abc']);
        }, '（忽略大小写）');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => ''], ['valStr' => 'StrNotInI:']);
        }, '不能等于""');
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrNotInI:Hello']);
            }, '必须是字符串');
        }
    }

    public function testValidateStrLens()
    {
        // StrLen
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLen:'.mb_strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLen:'.(mb_strlen($strVal)+1)]);
            }, '长度必须等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrLen:8']);
            }, '必须是字符串');
        }

        // StrLenGe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLenGe:'.mb_strlen($strVal)]);
            Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrLenGe:'.mb_strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLenGe:'.(mb_strlen($strVal)+1)]);
            }, '长度必须大于等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrLenGe:8']);
            }, '必须是字符串');
        }

        // StrLenLe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLenLe:'.mb_strlen($strVal)]);
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLenLe:'.mb_strlen($strVal.'1')]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrLenLe:'.mb_strlen($strVal)]);
            }, '长度必须小于等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrLenLe:8']);
            }, '必须是字符串');
        }

        // StrLenGeLe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'StrLenGeLe:'.mb_strlen($strVal).','.mb_strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'StrLenGeLe:'.mb_strlen($strVal).','.mb_strlen($strVal)]);
            }, '长度必须在'); //长度必须在 x - y 之间
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'StrLenGeLe:6,8']);
            }, '必须是字符串');
        }
    }

    public function testValidateByteLens()
    {
        // ByteLen
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLen:'.strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLen:'.(strlen($strVal)+1)]);
            }, '长度（字节）必须等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'ByteLen:8']);
            }, '必须是字符串');
        }

        // ByteLenGe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLenGe:'.strlen($strVal)]);
            Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'ByteLenGe:'.strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLenGe:'.(strlen($strVal)+1)]);
            }, '长度（字节）必须大于等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'ByteLenGe:8']);
            }, '必须是字符串');
        }

        // ByteLenLe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLenLe:'.strlen($strVal)]);
            Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLenLe:'.strlen($strVal.'1')]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'ByteLenLe:'.strlen($strVal)]);
            }, '长度（字节）必须小于等于');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'ByteLenLe:8']);
            }, '必须是字符串');
        }

        // ByteLenGeLe
        $strVals = ['', ' ', '  ', "\t", '123', 'abc', '你好', '-12311112311111'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'ByteLenGeLe:'.strlen($strVal).','.strlen($strVal)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($strVal) {
                Validation::validate(['valStr' => $strVal.'1'], ['valStr' => 'ByteLenGeLe:'.strlen($strVal).','.strlen($strVal)]);
            }, '长度（字节）必须在'); //长度必须在 x - y 之间
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'ByteLenGeLe:6,8']);
            }, '必须是字符串');
        }
    }

    public function testValidateOtherStrings()
    {
        // Letters
        $strVals = ['a', 'z', 'A', 'Z', 'abc', 'ABC', 'Hello', 'ZZZ', 'abc'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Letters']);
        }
        $wrongVals = ['', ' ', '  ', "\t", '123', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Letters']);
            }, '只能包含字母');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Letters']);
            }, '必须是字符串');
        }

        // Alphabet
        $strVals = ['a', 'z', 'A', 'Z', 'abc', 'ABC', 'Hello', 'ZZZ', 'abc'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Alphabet']);
        }
        $wrongVals = ['', ' ', '  ', "\t", '123', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Alphabet']);
            }, '只能包含字母');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Alphabet']);
            }, '必须是字符串');
        }

        // Numbers
        $strVals = ['0', '1', '123', '32456236234523452354324'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Numbers']);
        }
        $wrongVals = ['', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Numbers']);
            }, '只能是纯数字');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Numbers']);
            }, '必须是字符串');
        }

        // Digits
        $strVals = ['0', '1', '123', '32456236234523452354324'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Digits']);
        }
        $wrongVals = ['', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Digits']);
            }, '只能是纯数字');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Digits']);
            }, '必须是字符串');
        }

        // LettersNumbers
        $strVals = ['a', 'z', 'A', 'Z', 'abc', 'ABC', 'Hello', 'ZZZ', 'abc', '0', '1', '123', '32456236234523452354324', 'abc123'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'LettersNumbers']);
        }
        $wrongVals = ['_abc123', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'LettersNumbers']);
            }, '只能包含字母和数字');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'LettersNumbers']);
            }, '必须是字符串');
        }

        // Numeric
        $strVals = ['0', '-0', '0.0', '-0.0', '1', '-1', '1.0', '-1.0', '123', '-123', '123.0', '-123.0', '-.0', '.0', '1.', '-1.', '23412341234.423412341241234', '3245623623452341234234123452354324', '.3245623623452341234234123452354324', '3245623623452341234234123452354324.3245623623452341234234123452354324'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Numeric']);
        }
        $wrongVals = ['1.2.3', '.', '-.', '', ' ', '  ', "\t", ' 123', 'abc.def', '你好', 'abc123'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Numeric']);
            }, '必须是数值');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Numeric']);
            }, '必须是字符串');
        }

        // VarName
        $strVals = ['_', '_abc', '_abc123', 'a', 'z', 'A', 'Z', 'abc', 'ABC', 'Hello', 'ZZZ', 'abc', 'abc123'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'VarName']);
        }
        $wrongVals = ['0', '1', '123', '32456236234523452354324', '1abc', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'VarName']);
            }, '只能包含字母、数字和下划线，并且以字母或下划线开头');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'VarName']);
            }, '必须是字符串');
        }

        // Email
        $strVals = ['hi@abc.com', 'admin@webgeeker.com', 'hello@abc-def.com'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Email']);
        }
        $wrongVals = ['hi @abc.com', '0', '1', '123', '32456236234523452354324', '1abc', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Email']);
            }, '不是合法的email');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Email']);
            }, '必须是字符串');
        }

        // Url
        $strVals = ['http://abc.com', 'https://webgeeker.com', 'http://hello.com/p/1', 'http://hello.com/p/1?str=1&abc=123', 'ftp://abc.com'];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Url']);
        }
        $wrongVals = ['abc.com', '//abc.com', 'hi @abc.com', '0', '1', '123', '32456236234523452354324', '1abc', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Url']);
            }, '不是合法的Url地址');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Url']);
            }, '必须是字符串');
        }

        // Ip
        $strVals = ['1.1.1.1', '0.0.0.0', '8.8.8.8', '255.255.255.255',
            '::',
            '::1', // 本地回环地址.相当于ipv4的127.0.0.1
            '::ffff:192.168.89.9', // ipv4的ipv6形式（IPv4映射地址）
            '::ffff:c0a8:5909', // 等价于::ffff:192.168.89.9
            'fe80::', //fe80::/10－这些链路本地地址指明，这些地址只在区域连接中是合法的，这有点类似于IPv4中的169.254.0.0/16
            '169.254.0.0',
            '2001:0DB8:02de:0000:0000:0000:0000:0e13',
            '2001:DB8:2de:0000:0000:0000:0000:e13',
            '2001:DB8:2de:000:000:000:000:e13',
            '2001:DB8:2de:00:00:00:00:e13',
            '2001:DB8:2de:0:0:0:0:e13',
            '2001:DB8:2de::e13',
            '2001:0DB8:0000:0000:0000:0000:1428:57ab',
            '2001:0DB8:0000:0000:0000::1428:57ab',
            '2001:0DB8:0:0:0:0:1428:57ab',
            '2001:0DB8:0::0:1428:57ab',
            '2001:0DB8::1428:57ab',
        ];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Ip']);
        }
        $wrongVals = ['1.2.3.', '1.2.3.256', '2001::25de::cade', ':::',
            'abc.com', '//abc.com', 'hi @abc.com', '0', '1', '123', '32456236234523452354324', '1abc', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Ip']);
            }, '不是合法的IP地址');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Ip']);
            }, '必须是字符串');
        }

        // Mac
        $strVals = [
            '00:16:3e:02:02:9c',
            '00:0A:02:0B:03:0C',
            'ff:ff:ff:ff:ff:ff', // 广播地址
            '01:00:00:00:00:00', // 01:xx:xx:xx:xx:xx是多播地址
            '01:00:5e:00:00:00', // 01:00:5e:xx:xx:xx是IPv4多播地址
        ];
        foreach ($strVals as $strVal) {
            Validation::validate(['valStr' => $strVal], ['valStr' => 'Mac']);
        }
        $wrongVals = ['00:16:3e:02:02:9', '1.2.3.', '1.2.3.256', '2001::25de::cade', ':::',
            'abc.com', '//abc.com', 'hi @abc.com', '0', '1', '123', '32456236234523452354324', '1abc', '', ' ', '  ', "\t", ' 123', '-123', '1.0', 'abc.def', '你好', '-12311112311111'];
        foreach ($wrongVals as $wrongVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($wrongVal) {
                Validation::validate(['valStr' => $wrongVal], ['valStr' => 'Mac']);
            }, '不是合法的MAC地址');
        }
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Mac']);
            }, '必须是字符串');
        }

    }

    public function testValidateRegexp()
    {
        $valExps = [
            '0123456789' => '/345/',
            '10.' => '/^[0-9.]+$/',
            '10/ab|cd' => '/^[0-9]+\/ab\|cd$/',
            'var=123' => '/^\s*var\s*=\s*[0-9]+\s*$/',
            ' var = 123 ' => '/^\s*var\s*=\s*[0-9]+\s*$/',
        ];
        foreach ($valExps as $val => $exp) {
            Validation::validate(['valStr' => $val], ['valStr' => 'Regexp:'.$exp]);
        }
        $notMatchValExps = [
            'a10.' => '/^[0-9.]+$/',
            'a10/abcd' => '/^[0-9]+\/abcd$/',
        ];
        foreach ($notMatchValExps as $val => $exp) {
            $this->_assertThrowExpectionContainErrorString(function () use ($val, $exp) {
                Validation::validate(['valStr' => $val], ['valStr' => 'Regexp:'.$exp]);
            }, '不匹配正则表达式');
        }
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abc'], ['valStr' => 'Regexp:/abc']);
        }, '正则表达式验证器Regexp格式错误');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['valStr' => 'abc'], ['valStr' => 'Regexp:abc/']);
        }, '正则表达式验证器Regexp格式错误');
        $notStrVals = [1, 0, 1.0, 0.0, true, false, []];
        foreach ($notStrVals as $notStrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notStrVal) {
                Validation::validate(['valStr' => $notStrVal], ['valStr' => 'Regexp:/abc/']);
            }, '必须是字符串');
        }
    }

    public function testValidateArr()
    {
        // Arr
        $arrays = [
            [],
            [1, 2, 3],
            ['abc', '123', 'hello', 'hi'],
        ];
        foreach ($arrays as $array) {
            Validation::validate(['array' => $array], ['array' => 'Arr']);
        }
        $notArrVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            ['var'=>123], // 这是Obj
        ];
        foreach ($notArrVals as $notArrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notArrVal) {
                Validation::validate(['array' => $notArrVal], ['array' => 'Arr']);
            }, '必须是数组');
        }

        // ArrLen
        $arrays = [
            [],
            [1, 2, 3],
            ['abc', '123', 'hello', 'hi'],
        ];
        foreach ($arrays as $array) {
            Validation::validate(['array' => $array], ['array' => 'ArrLen:'.count($array)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($array) {
                Validation::validate(['array' => $array], ['array' => 'ArrLen:'.(count($array)+1)]);
            }, '长度必须等于');
        }
        $notArrVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            ['var'=>123], // 这是Obj
        ];
        foreach ($notArrVals as $notArrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notArrVal) {
                Validation::validate(['array' => $notArrVal], ['array' => 'ArrLen:999']);
            }, '必须是数组');
        }

        // ArrLenGe
        $arrays = [
            [],
            [1, 2, 3],
            ['abc', '123', 'hello', 'hi'],
        ];
        foreach ($arrays as $array) {
            Validation::validate(['array' => $array], ['array' => 'ArrLenGe:'.count($array)]);
            Validation::validate(['array' => array_merge($array, ['haha'])], ['array' => 'ArrLenGe:'.count($array)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($array) {
                Validation::validate(['array' => $array], ['array' => 'ArrLenGe:'.(count($array)+1)]);
            }, '长度必须大于等于');
        }
        $notArrVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            ['var'=>123], // 这是Obj
        ];
        foreach ($notArrVals as $notArrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notArrVal) {
                Validation::validate(['array' => $notArrVal], ['array' => 'ArrLenGe:999']);
            }, '必须是数组');
        }

        // ArrLenLe
        $arrays = [
            [],
            [1, 2, 3],
            ['abc', '123', 'hello', 'hi'],
        ];
        foreach ($arrays as $array) {
            Validation::validate(['array' => $array], ['array' => 'ArrLenLe:'.count($array)]);
            Validation::validate(['array' => $array], ['array' => 'ArrLenLe:'.(count($array)+1)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($array) {
                Validation::validate(['array' => array_merge($array, ['haha'])], ['array' => 'ArrLenLe:'.count($array)]);
            }, '长度必须小于等于');
        }
        $notArrVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            ['var'=>123], // 这是Obj
        ];
        foreach ($notArrVals as $notArrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notArrVal) {
                Validation::validate(['array' => $notArrVal], ['array' => 'ArrLenLe:999']);
            }, '必须是数组');
        }

        // ArrLenGeLe
        $arrays = [
            [],
            [1, 2, 3],
            ['abc', '123', 'hello', 'hi'],
        ];
        foreach ($arrays as $array) {
            Validation::validate(['array' => $array], ['array' => 'ArrLenGeLe:'.count($array).','.count($array)]);
            $this->_assertThrowExpectionContainErrorString(function () use ($array) {
                Validation::validate(['array' => array_merge($array, ['haha'])], ['array' => 'ArrLenGeLe:'.count($array).','.count($array)]);
            }, '长度必须在');
        }
        $notArrVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            ['var'=>123], // 这是Obj
        ];
        foreach ($notArrVals as $notArrVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notArrVal) {
                Validation::validate(['array' => $notArrVal], ['array' => 'ArrLenGeLe:1,999']);
            }, '必须是数组');
        }
    }

    public function testValidateObj()
    {
        // Obj
        $objs = [
            [],
            ['a' => 1],
            ['abc' => '123', 'hello' => 'hi'],
        ];
        foreach ($objs as $obj) {
            Validation::validate(['obj' => $obj], ['obj' => 'Obj']);
        }
        $notObjVals = [1, 0, 1.0, 0.0, true, false, 'asd',
            [1, 2, 3], // 这是Arr
        ];
        foreach ($notObjVals as $notObjVal) {
            $this->_assertThrowExpectionContainErrorString(function () use ($notObjVal) {
                Validation::validate(['obj' => $notObjVal], ['obj' => 'Obj']);
            }, '必须是对象');
        }
    }

    public function testValidateFile()
    {
        // 缺少某些字段
        $params = [
            'file' => [
//                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'File']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 正常的文件
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'File']);

        // 文件上传错误
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 1, // 文件上传错误
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'File']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 文件数组
        $params = [
            'file' => [
                "name" => ["audio_爱情买卖.mp4"],
                "type" => ["video/mp4"],
                "tmp_name" => ["/Applications/MAMP/tmp/php/php19AQMs"],
                "error" => [0],
                "size" => [2873551]
            ],
        ];
        Validation::validate($params, ['file' => 'File']);

        // 文件数组上传错误
        $params = [
            'file' => [
                "name" => ["audio_爱情买卖.mp4"],
                "type" => ["video/mp4"],
                "tmp_name" => ["/Applications/MAMP/tmp/php/php19AQMs"],
                "error" => [1], // 文件上传错误
                "size" => [2873551]
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'File']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

    }

    public function testValidateFileTypes()
    {
        // 图片
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.jpg",
                "type" => "image/jpeg",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'FileImage']);

        // 不是图片
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileImage']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 图片数组
        $params = [
            'file' => [
                "name" => ["audio_爱情买卖.jpg"],
                "type" => ["image/jpeg"],
                "tmp_name" => ["/Applications/MAMP/tmp/php/php19AQMs"],
                "error" => [0],
                "size" => [2873551]
            ],
        ];
        Validation::validate($params, ['file' => 'FileImage']);

        // 不是图片数组
        $params = [
            'file' => [
                "name" => ["audio_爱情买卖.mp4"],
                "type" => ["video/mp4"],
                "tmp_name" => ["/Applications/MAMP/tmp/php/php19AQMs"],
                "error" => [0],
                "size" => [2873551]
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileImage']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 视频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'FileVideo']);

        // 不是视频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.jpg",
                "type" => "image/jpeg",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileVideo']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 音频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp3",
                "type" => "audio/mp3",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'FileAudio']);

        // 不是音频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.jpg",
                "type" => "image/jpeg",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileAudio']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

    }

    public function testValidateFileMimes()
    {
        // FileMimes格式书写错误
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:video/']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:/']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:*/png']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:/png']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:*']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validate([], ['file' => 'FileMimes:*/*']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // mp3检测为音频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp3",
                "type" => "audio/mp3",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'FileMimes:audio/*,mp4|>>>:file必须是音频文件']);
        // mp4也可被当作音频
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        Validation::validate($params, ['file' => 'FileMimes:audio/*,mp4|>>>:file必须是音频文件']);

        // xaudio/mp3 不会匹配 audio/*
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp3",
                "type" => "xaudio/mp3",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMimes:audio/*,mp4|>>>:file必须是音频文件']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        // audio/mp3 不会匹配 xaudio/*
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp3",
                "type" => "audio/mp3",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMimes:xaudio/*,mp4|>>>:file必须是音频文件']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        // "video/mp4x" 不会匹配 mp4
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4x",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMimes:audio/*,mp4|>>>:file必须是音频文件']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
        // "video/mp4" 不会匹配 mp4x
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 2873551
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMimes:audio/*,mp4x|>>>:file必须是音频文件']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

    }

    public function testValidateFileSize()
    {
        // 文件大小为0
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 0
            ],
        ];
        Validation::validate($params, ['file' => 'FileMinSize:0|FileMaxSize:0']);

        // FileMaxSize 检测通过
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 1048576
            ],
        ];
        Validation::validate($params, ['file' => 'FileMaxSize:1m']);

        // FileMaxSize 检测不通过
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 1025
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMaxSize:1k']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // FileMinSize 检测通过
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 100
            ],
        ];
        Validation::validate($params, ['file' => 'FileMinSize:100']);

        // FileMinSize 检测不通过
        $params = [
            'file' => [
                "name" => "audio_爱情买卖.mp4",
                "type" => "video/mp4",
                "tmp_name" => "/Applications/MAMP/tmp/php/php19AQMs",
                "error" => 0,
                "size" => 999999
            ],
        ];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['file' => 'FileMinSize:1000000']);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

    }

    public function testValidateDate()
    {
        // Date
        Validation::validate(['date' => '2017-06-01'], ['date' => 'Date']);
        Validation::validate(['date' => '2017-6-1'], ['date' => 'Date']);
        Validation::validate(['date' => '2017-6-01'], ['date' => 'Date']);
        Validation::validate(['date' => '2017-06-1'], ['date' => 'Date']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['date' => '17-6-1'], ['date' => 'Date']);
        }, '必须符合日期格式YYYY-MM-DD');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['date' => '2017 6 1'], ['date' => 'Date']);
        }, '必须符合日期格式YYYY-MM-DD');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['date' => '2017/6/1'], ['date' => 'Date']);
        }, '必须符合日期格式YYYY-MM-DD');

        // DateFrom
        Validation::validate(['date' => '2017-06-15'], ['date' => 'DateFrom:2017-06-15']);
        Validation::validate(['date' => '2017-06-16'], ['date' => 'DateFrom:2017-06-15']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期范围错误
            Validation::validate(['date' => '2017-06-14'], ['date' => 'DateFrom:2017-06-15']);
        }, '不得早于');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期格式错误
            Validation::validate(['date' => 'aaaa-06-15'], ['date' => 'DateFrom:2017-06-15']);
        }, '必须符合日期格式YYYY-MM-DD');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期验证器格式错误
            Validation::validate(['date' => '2017-06-15'], ['date' => 'DateFrom:2017/06\15']);
        }, 'DateFrom格式错误');

        // DateTo
        Validation::validate(['date' => '2017-06-15'], ['date' => 'DateTo:2017-06-15']);
        Validation::validate(['date' => '2017-06-14'], ['date' => 'DateTo:2017-06-15']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期范围错误
            Validation::validate(['date' => '2017-06-16'], ['date' => 'DateTo:2017-06-15']);
        }, '不得晚于');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期格式错误
            Validation::validate(['date' => 'aaaa-06-15'], ['date' => 'DateTo:2017-06-15']);
        }, '必须符合日期格式YYYY-MM-DD');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期验证器格式错误
            Validation::validate(['date' => '2017-06-15'], ['date' => 'DateTo:2017/06\15']);
        }, 'DateTo格式错误');

        // DateFromTo
        Validation::validate(['date' => '2017-06-15'], ['date' => 'DateFromTo:2017-06-15,2017-06-15']);
        Validation::validate(['date' => '2017-06-15'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        Validation::validate(['date' => '2017-06-10'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        Validation::validate(['date' => '2017-06-20'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期范围错误
            Validation::validate(['date' => '2017-06-09'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        }, '必须在');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期范围错误
            Validation::validate(['date' => '2017-06-21'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        }, '必须在');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期格式错误
            Validation::validate(['date' => 'aaaa-06-15'], ['date' => 'DateFromTo:2017-06-10,2017-06-20']);
        }, '必须符合日期格式YYYY-MM-DD');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期验证器格式错误
            Validation::validate(['date' => '2017-06-15'], ['date' => 'DateFromTo:2017-06-15']);
        }, 'DateFromTo格式错误');

    }

    public function testValidateDateTime()
    {
        // DateTime
        Validation::validate(['datetime' => '2017-06-01 12:00:00'], ['datetime' => 'DateTime']);
        Validation::validate(['datetime' => '2017-6-1 12:00:00'], ['datetime' => 'DateTime']);
        Validation::validate(['datetime' => '2017-6-01 12:00:00'], ['datetime' => 'DateTime']);
        Validation::validate(['datetime' => '2017-06-1 12:00:00'], ['datetime' => 'DateTime']);
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['datetime' => '2017-06-01 12:00:aa'], ['datetime' => 'DateTime']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['datetime' => '2017-06-01 12 00 00'], ['datetime' => 'DateTime']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');
        $this->_assertThrowExpectionContainErrorString(function () {
            Validation::validate(['datetime' => '2017-06-01 12/00/00'], ['datetime' => 'DateTime']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');

        // DateTimeFrom
        Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeFrom:2017-06-15 12:00:00']);
        Validation::validate(['datetime' => '2017-06-15 12:00:01'], ['datetime' => 'DateTimeFrom:2017-06-15 12:00:00']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间范围错误
            Validation::validate(['datetime' => '2017-06-15 11:59:59'], ['datetime' => 'DateTimeFrom:2017-06-15 12:00:00']);
        }, '不得早于');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间格式错误
            Validation::validate(['datetime' => '2017-06-15 11:59:aa'], ['datetime' => 'DateTimeFrom:2017-06-15 12:00:00']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间验证器格式错误
            Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeFrom:2017-06-15 12/00/00']);
        }, 'DateTimeFrom格式错误');

        // DateTo
        Validation::validate(['datetime' => '2017-06-15 11:59:59'], ['datetime' => 'DateTimeTo:2017-06-15 12:00:00']);
        Validation::validate(['datetime' => '2017-06-15 11:59:58'], ['datetime' => 'DateTimeTo:2017-06-15 12:00:00']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间范围错误
            Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeTo:2017-06-15 12:00:00']);
        }, '必须早于');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间格式错误
            Validation::validate(['datetime' => '2017-06-15 12:00:aa'], ['datetime' => 'DateTimeTo:2017-06-15 12:00:00']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间验证器格式错误
            Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeTo:2017-06-15 12/00/00']);
        }, 'DateTimeTo格式错误');

        // DateTimeFromTo
        Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        Validation::validate(['datetime' => '2017-06-15 12:30:00'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        Validation::validate(['datetime' => '2017-06-15 12:59:59'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间范围错误
            Validation::validate(['datetime' => '2017-06-15 11:59:59'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        }, '必须在');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间范围错误
            Validation::validate(['datetime' => '2017-06-15 13:00:00'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        }, '必须在');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间格式错误
            Validation::validate(['datetime' => '2017-06-15 12:00:aa'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00,2017-06-15 13:00:00']);
        }, '必须符合日期时间格式YYYY-MM-DD HH:mm:ss');
        $this->_assertThrowExpectionContainErrorString(function () {
            // 日期时间验证器格式错误
            Validation::validate(['datetime' => '2017-06-15 12:00:00'], ['datetime' => 'DateTimeFromTo:2017-06-15 12:00:00']);
        }, 'DateTimeFromTo格式错误');

    }

    public function testValidateOthers()
    {
        // 验证器为空时
        Validation::validate(['id' => 1], ['id' => '']);

        // 自定义验证失败的提示 >>>
        $this->assertNotNull(Validation::validateValue(1, 'Int|>>>:验证会通过,不会抛出异常'));
        try {
            Validation::validateValue([1, 2, 3], 'Int|>>>:对不起, 您必须输入一个整数');
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertEquals('对不起, 您必须输入一个整数', $errstr);
        }
        try {
            Validation::validateValue([1, 2, 3], 'Int|>>>:|>>>:ERROR: 您必须输入一个整数|Arr');
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertEquals('|>>>:ERROR: 您必须输入一个整数|Arr', $errstr);
        }
        try {
            Validation::validateValue(123, 'Int|Str|>>>:对不起, 您必须输入一个包含数字的字符串');
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertEquals('对不起, 您必须输入一个包含数字的字符串', $errstr);
        }

        // 参数别名相关
        try {
            Validation::validateValue('abc', 'Alias:参数别名|Int', null);
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertStringMatchesFormat('%S参数别名%S', $errstr);
        }
        try {
            Validation::validateValue('abc', 'Bool|Alias:param alias', null);
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertStringMatchesFormat('%Sparam alias%S', $errstr);
        }
        Validation::validateValue('abc', 'Alias:参数别名', null);
    }

    public function testValidateCompile()
    {
        Validation::validateValue('1||2/3/', 'Regexp:/^1\|\|2\/3\//');
    }

    public function testValidateIfBools()
    {
        // If
        $trues = [1, '1', true, 'true', 'yes', 'y'];
        $falses = [0, '0', false, 'false', 'no', 'n', 'hello', 2.5]; //'hello'和2.5即不是true, 也不是false
        for ($i = 0; $i < count($trues); $i++) {
            for ($j = 0; $j < count($falses); $j++) {
                $true = $trues[$i];
                $false = $falses[$j];

                $params = ['type' => $false, 'state' => 0];
                Validation::validate($params, ['state' => 'If:type|IntEq:0']); //条件不成立+验证通过（忽略这条）
                Validation::validate($params, ['state' => 'If:type|IntEq:1']); //条件不成立+验证不通过（忽略这条）
                $params = ['type' => $true, 'state' => 0];
                Validation::validate($params, ['state' => 'If:type|IntEq:0']); //条件成立+验证通过
                $this->_assertThrowExpection(function () use ($params) {
                    Validation::validate($params, ['state' => 'If:type|IntEq:1']); //条件成立+验证不通过
                }, 'line ' . __LINE__ . ": 应该抛出异常");

            }
        }

        // IfNot
        $trues = [1, '1', true, 'true', 'yes', 'y', 'hello', 2.5]; //'hello'和2.5即不是true, 也不是false
        $falses = [0, '0', false, 'false', 'no', 'n'];
        for ($i = 0; $i < count($trues); $i++) {
            for ($j = 0; $j < count($falses); $j++) {
                $true = $trues[$i];
                $false = $falses[$j];

                $params = ['type' => $true, 'state' => 0];
                Validation::validate($params, ['state' => 'IfNot:type|IntEq:0']); //条件不成立+验证通过（忽略这条）
                Validation::validate($params, ['state' => 'IfNot:type|IntEq:1']); //条件不成立+验证不通过（忽略这条）
                $params = ['type' => $false, 'state' => 0];
                Validation::validate($params, ['state' => 'IfNot:type|IntEq:0']); //条件成立+验证通过
                $this->_assertThrowExpection(function () use ($params) {
                    Validation::validate($params, ['state' => 'IfNot:type|IntEq:1']); //条件成立+验证不通过
                }, 'line ' . __LINE__ . ": 应该抛出异常");

            }
        }

        // IfTrue
        $trues = [true, 'true'];
        $falses = [false, 'false', 'hello', 2.5]; //'hello'和2.5即不是true, 也不是false
        for ($i = 0; $i < count($trues); $i++) {
            for ($j = 0; $j < count($falses); $j++) {
                $true = $trues[$i];
                $false = $falses[$j];

                $params = ['type' => $false, 'state' => 0];
                Validation::validate($params, ['state' => 'IfTrue:type|IntEq:0']); //条件不成立+验证通过（忽略这条）
                Validation::validate($params, ['state' => 'IfTrue:type|IntEq:1']); //条件不成立+验证不通过（忽略这条）
                $params = ['type' => $true, 'state' => 0];
                Validation::validate($params, ['state' => 'IfTrue:type|IntEq:0']); //条件成立+验证通过
                $this->_assertThrowExpection(function () use ($params) {
                    Validation::validate($params, ['state' => 'IfTrue:type|IntEq:1']); //条件成立+验证不通过
                }, 'line ' . __LINE__ . ": 应该抛出异常");

            }
        }

        // IfFalse
        $trues = [true, 'true', 'hello', 2.5]; //'hello'和2.5即不是true, 也不是false
        $falses = [false, 'false'];
        for ($i = 0; $i < count($trues); $i++) {
            for ($j = 0; $j < count($falses); $j++) {
                $true = $trues[$i];
                $false = $falses[$j];

                $params = ['type' => $true, 'state' => 0];
                Validation::validate($params, ['state' => 'IfFalse:type|IntEq:0']); //条件不成立+验证通过（忽略这条）
                Validation::validate($params, ['state' => 'IfFalse:type|IntEq:1']); //条件不成立+验证不通过（忽略这条）
                $params = ['type' => $false, 'state' => 0];
                Validation::validate($params, ['state' => 'IfFalse:type|IntEq:0']); //条件成立+验证通过
                $this->_assertThrowExpection(function () use ($params) {
                    Validation::validate($params, ['state' => 'IfFalse:type|IntEq:1']); //条件成立+验证不通过
                }, 'line ' . __LINE__ . ": 应该抛出异常");

            }
        }
    }

    public function testValidateIfExists()
    {
        // IfExist
        $existVals = [0, 123, '', '123', true, false, 0.0, 1.0, [], [1, 2, 3]];
        $notExistVals = [null, 'undefined']; // 后面对 'undefined' 会作特殊处理
        for ($i = 0; $i < count($existVals); $i++) {
            for ($j = 0; $j < count($notExistVals); $j++) {
                $existVal = $existVals[$i];
                $notExistVal = $notExistVals[$j];

                $params = ['param1' => $notExistVal, 'param2' => 0];
                if ($notExistVal === 'undefined') unset($params['param1']);
                //条件不成立+验证通过（这条会被忽略）
                Validation::validate($params, ['param2' => 'IfExist:param1|IntEq:0']);
                //条件不成立+验证不通过（这条会被忽略）
                Validation::validate($params, ['param2' => 'IfExist:param1|IntEq:1']);

                $params = ['param1' => $existVal, 'param2' => 0];
                //条件成立+验证通过
                Validation::validate($params, ['param2' => 'IfExist:param1|IntEq:0']);
                $this->_assertThrowExpection(function () use ($params) {
                    //条件成立+验证不通过
                    Validation::validate($params, ['param2' => 'IfExist:param1|IntEq:1']);
                }, 'line ' . __LINE__ . ": 应该抛出异常");
            }
        }

        // IfNotExist
        $existVals = [0, 123, '', '123', true, false, 0.0, 1.0, [], [1, 2, 3]];
        $notExistVals = [null, 'undefined']; // 后面对 'undefined' 会作特殊处理
        for ($i = 0; $i < count($existVals); $i++) {
            for ($j = 0; $j < count($notExistVals); $j++) {
                $existVal = $existVals[$i];
                $notExistVal = $notExistVals[$j];

                $params = ['param1' => $existVal, 'param2' => 0];
                //条件不成立+验证通过（这条会被忽略）
                Validation::validate($params, ['param2' => 'IfNotExist:param1|IntEq:0']);
                //条件不成立+验证不通过（这条会被忽略）
                Validation::validate($params, ['param2' => 'IfNotExist:param1|IntEq:1']);

                $params = ['param1' => $notExistVal, 'param2' => 0];
                if ($notExistVal === 'undefined') unset($params['param1']);
                //条件成立+验证通过
                Validation::validate($params, ['param2' => 'IfNotExist:param1|IntEq:0']);
                $this->_assertThrowExpection(function () use ($params) {
                    //条件成立+验证不通过
                    Validation::validate($params, ['param2' => 'IfNotExist:param1|IntEq:1']);
                }, 'line ' . __LINE__ . ": 应该抛出异常");
            }
        }
    }

    public function testValidateIfIntXx()
    {
        // 检测格式书写错误: IfIntXx:condition,abc
        $this->_assertThrowExpection(function () {
            $params = ['condition' => 1, 'param' => 1];
            //抛出异常: “IfIntEq:condition,abc”中“condition”后面必须是整数，实际上却是“abc”
            Validation::validate($params, ['param' => "IfIntEq:condition,abc|IntEq:1"]);
        }, 'line ' . __LINE__ . ": 应该抛出异常");
    }

    public function testValidateIfIntEq()
    {
        // IfIntEq
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntEq:condition,$intVal2|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntEq:condition,$intVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntEq:condition,$intVal|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params, $intVal) {
                Validation::validate($params, ['param' => "IfIntEq:condition,$intVal|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntEq 验证参数类型错误导致的条件不成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntEq:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntEq:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfIntNe()
    {
        // IfIntNe
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntNe:condition,$intVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntNe:condition,$intVal|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntNe:condition,$intVal2|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 1;
            $this->_assertThrowExpection(function () use ($params, $intVal2) {
                Validation::validate($params, ['param' => "IfIntNe:condition,$intVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntNe 验证参数类型错误导致的条件成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件成立+验证通过
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntNe:condition,0|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $notIntVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfIntNe:condition,1|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }
    }

    public function testValidateIfIntGt()
    {
        // IfIntGt
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntGt:condition,$intVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntGt:condition,$intVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal - 1;
            Validation::validate($params, ['param' => "IfIntGt:condition,$intVal2|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal - 10;
            $this->_assertThrowExpection(function () use ($params, $intVal2) {
                Validation::validate($params, ['param' => "IfIntGt:condition,$intVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntGt 验证参数类型错误导致的条件不成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件不成立+验证通过
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntGt:condition,0|IntEq:1"]);

            //条件不成立+验证不通过
            $params = ['condition' => $notIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntGt:condition,1|IntEq:1"]);
        }
    }

    public function testValidateIfIntGe()
    {
        // IfIntGe
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntGe:condition,$intVal2|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 2;
            Validation::validate($params, ['param' => "IfIntGe:condition,$intVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntGe:condition,$intVal|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal - 1;
            $this->_assertThrowExpection(function () use ($params, $intVal2) {
                Validation::validate($params, ['param' => "IfIntGe:condition,$intVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntGe 验证参数类型错误导致的条件不成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件不成立+验证通过
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntGe:condition,0|IntEq:1"]);

            //条件不成立+验证不通过
            $params = ['condition' => $notIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntGe:condition,1|IntEq:1"]);
        }
    }

    public function testValidateIfIntLt()
    {
        // IfIntLt
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntLt:condition,$intVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal - 1;
            Validation::validate($params, ['param' => "IfIntLt:condition,$intVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal + 1;
            Validation::validate($params, ['param' => "IfIntLt:condition,$intVal2|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 10;
            $this->_assertThrowExpection(function () use ($params, $intVal2) {
                Validation::validate($params, ['param' => "IfIntLt:condition,$intVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntLt 验证参数类型错误导致的条件不成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件不成立+验证通过
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntLt:condition,0|IntEq:1"]);

            //条件不成立+验证不通过
            $params = ['condition' => $notIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntLt:condition,1|IntEq:1"]);
        }
    }

    public function testValidateIfIntLe()
    {
        // IfIntLe
        $intVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intVals); $i++) {
            $intVal = $intVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 1];
            $intVal2 = $intVal - 1;
            Validation::validate($params, ['param' => "IfIntLe:condition,$intVal2|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal - 2;
            Validation::validate($params, ['param' => "IfIntLe:condition,$intVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $intVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntLe:condition,$intVal|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intVal, 'param' => 0];
            $intVal2 = $intVal + 1;
            $this->_assertThrowExpection(function () use ($params, $intVal2) {
                Validation::validate($params, ['param' => "IfIntLe:condition,$intVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntLe 验证参数类型错误导致的条件不成立的情况
        $notIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 不是整型也不是整型字符串
        for ($i = 0; $i < count($notIntVals); $i++) {
            $notIntVal = $notIntVals[$i];
            //条件不成立+验证通过
            $params = ['condition' => $notIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntLe:condition,0|IntEq:1"]);

            //条件不成立+验证不通过
            $params = ['condition' => $notIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntLe:condition,1|IntEq:1"]);
        }
    }

    public function testValidateIfIntIn()
    {
        // IfIntIn 条件成立
        $intInVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intInVals); $i++) {
            $intInVal = $intInVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $intInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intInVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntIn 条件不成立
        $intNotInVals = [-13, 13, -123, 123, '-13', '13', '-123', '123'];
        for ($i = 0; $i < count($intNotInVals); $i++) {
            $intNotInVal = $intNotInVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intNotInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intNotInVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);
        }

        // IfIntIn 条件参数类型错误导致的条件不成立的情况
        $nonIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 非整型值的数组
        for ($i = 0; $i < count($nonIntVals); $i++) {
            $nonIntVal = $nonIntVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $nonIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $nonIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntIn:condition,-100,-1,0,1,100|IntEq:1"]);
        }
    }

    public function testValidateIfIntNotIn()
    {
        // IfIntNotIn 条件不成立
        $intInVals = [0, -1, 1, 100, -100, '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($intInVals); $i++) {
            $intInVal = $intInVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intInVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);
        }

        // IfIntNotIn 条件成立
        $intNotInVals = [-13, 13, -123, 123, '-13', '13', '-123', '123'];
        for ($i = 0; $i < count($intNotInVals); $i++) {
            $intNotInVal = $intNotInVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $intNotInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intNotInVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfIntNotIn 条件参数类型错误导致的条件成立的情况
        $nonIntVals = [true, false, 1.0, 0.0, '1.0', '0.0', '', 'abc', [], [1, 2, 3]]; // 非整型值的数组
        for ($i = 0; $i < count($nonIntVals); $i++) {
            $nonIntVal = $nonIntVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $nonIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $nonIntVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfIntNotIn:condition,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }
    }

    public function testValidateIfStrEq()
    {
        // IfStrEq
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 1];
            $strVal2 = $strVal . 'p';
            Validation::validate($params, ['param' => "IfStrEq:condition,$strVal2|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . '0';
            Validation::validate($params, ['param' => "IfStrEq:condition,$strVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrEq:condition,$strVal|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $strVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params, $strVal) {
                Validation::validate($params, ['param' => "IfStrEq:condition,$strVal|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrEq 验证参数类型错误导致的条件不成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrEq:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrEq:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfStrNe()
    {
        // IfStrNe
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrNe:condition,$strVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrNe:condition,$strVal|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $strVal, 'param' => 1];
            $strVal2 = $strVal . 'p';
            Validation::validate($params, ['param' => "IfStrNe:condition,$strVal2|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . '0';
            $this->_assertThrowExpection(function () use ($params, $strVal2) {
                Validation::validate($params, ['param' => "IfStrNe:condition,$strVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrNe 验证参数类型错误导致的条件成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件成立+验证通过
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrNe:condition,0|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $notStrVal, 'param' => 0];
            $notStrVal2 = $notStrVal . 'a';
            $this->_assertThrowExpection(function () use ($params, $notStrVal2) {
                Validation::validate($params, ['param' => "IfStrNe:condition,$notStrVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

    }

    public function testValidateIfStrGt()
    {
        // IfStrGt
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrGt:condition,$strVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . '0';
            Validation::validate($params, ['param' => "IfStrGt:condition,$strVal2|IntEq:1"]);

            //条件成立+验证通过
            $strVal2 = $strVal . '0';
            $params = ['condition' => $strVal2, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrGt:condition,$strVal|IntEq:1"]);

            //条件成立+验证不通过
            $strVal2 = $strVal . 'a';
            $params = ['condition' => $strVal2, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params, $strVal) {
                Validation::validate($params, ['param' => "IfStrGt:condition,$strVal|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrGt 验证参数类型错误导致的条件不成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrGt:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrGt:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfStrGe()
    {
        // IfStrGe
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 1];
            $strVal2 = $strVal . 'a';
            Validation::validate($params, ['param' => "IfStrGe:condition,$strVal2|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . '0';
            Validation::validate($params, ['param' => "IfStrGe:condition,$strVal2|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrGe:condition,$strVal|IntEq:1"]);

            //条件成立+验证不通过
            $strVal2 = $strVal . 'a';
            $params = ['condition' => $strVal2, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params, $strVal) {
                Validation::validate($params, ['param' => "IfStrGe:condition,$strVal|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrGe 验证参数类型错误导致的条件不成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrGe:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrGe:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfStrLt()
    {
        // IfStrLt
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrLt:condition,$strVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $strVal2 = $strVal . '0';
            $params = ['condition' => $strVal2, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrLt:condition,$strVal|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $strVal, 'param' => 1];
            $strVal2 = $strVal . '0';
            Validation::validate($params, ['param' => "IfStrLt:condition,$strVal2|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . 'a';
            $this->_assertThrowExpection(function () use ($params, $strVal2) {
                Validation::validate($params, ['param' => "IfStrLt:condition,$strVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrLt 验证参数类型错误导致的条件不成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrLt:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrLt:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfStrLe()
    {
        // IfStrLe
        $strVals = ['', 'a', '0', '-1', '1', '100', '-100', 'abc', '1.0'];
        for ($i = 0; $i < count($strVals); $i++) {
            $strVal = $strVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $strVal2 = $strVal . 'a';
            $params = ['condition' => $strVal2, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrLe:condition,$strVal|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $strVal2 = $strVal . '0';
            $params = ['condition' => $strVal2, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrLe:condition,$strVal|IntEq:1"]);

            //条件成立+验证通过
            $params = ['condition' => $strVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrLe:condition,$strVal|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $strVal, 'param' => 0];
            $strVal2 = $strVal . 'a';
            $this->_assertThrowExpection(function () use ($params, $strVal2) {
                Validation::validate($params, ['param' => "IfStrLe:condition,$strVal2|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrLe 验证参数类型错误导致的条件不成立的情况
        $notStrVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 不是字符串型
        for ($i = 0; $i < count($notStrVals); $i++) {
            $notStrVal = $notStrVals[$i];
            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrLe:condition,0|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $notStrVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrLe:condition,1|IntEq:1"]);
        }

    }

    public function testValidateIfStrIn()
    {
        // IfStrIn 条件成立
        $strInVals = ['', 'abc', '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($strInVals); $i++) {
            $strInVal = $strInVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $strInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $strInVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }

        // IfStrIn 条件不成立
        $intNotInVals = ['hello', 'world', '-13', '13', '-123', '123'];
        for ($i = 0; $i < count($intNotInVals); $i++) {
            $intNotInVal = $intNotInVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $intNotInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $intNotInVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
        }
        $params = ['condition' => '', 'param' => 1];
        Validation::validate($params, ['param' => "IfStrIn:condition,abc,-100,-1,0,1,100|IntEq:1"]);
        $params = ['condition' => '', 'param' => 0];
        Validation::validate($params, ['param' => "IfStrIn:condition,abc,-100,-1,0,1,100|IntEq:1"]);

        // IfStrIn 条件参数类型错误导致的条件不成立的情况
        $nonIntVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 非整型值的数组
        for ($i = 0; $i < count($nonIntVals); $i++) {
            $nonIntVal = $nonIntVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $nonIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $nonIntVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
        }
    }

    public function testValidateIfStrNotIn()
    {
        // IfStrNotIn 条件不成立
        $strInVals = ['', 'abc', '0', '-1', '1', '100', '-100',];
        for ($i = 0; $i < count($strInVals); $i++) {
            $strInVal = $strInVals[$i];

            //条件不成立+验证通过（此条检测会被忽略）
            $params = ['condition' => $strInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件不成立+验证不通过（此条检测会被忽略）
            $params = ['condition' => $strInVal, 'param' => 0];
            Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
        }

        // IfStrNotIn 条件成立
        $intNotInVals = ['hello', 'world', '-13', '13', '-123', '123'];
        for ($i = 0; $i < count($intNotInVals); $i++) {
            $intNotInVal = $intNotInVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $intNotInVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $intNotInVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }
        $params = ['condition' => '', 'param' => 1];
        Validation::validate($params, ['param' => "IfStrNotIn:condition,abc,-100,-1,0,1,100|IntEq:1"]);
        $params = ['condition' => '', 'param' => 0];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['param' => "IfStrNotIn:condition,abc,-100,-1,0,1,100|IntEq:1"]);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // IfStrNotIn 条件参数类型错误导致的条件成立的情况
        $nonIntVals = [true, false, 1, 0, 1.0, 0.0, [], [1, 2, 3]]; // 非整型值的数组
        for ($i = 0; $i < count($nonIntVals); $i++) {
            $nonIntVal = $nonIntVals[$i];

            //条件成立+验证通过
            $params = ['condition' => $nonIntVal, 'param' => 1];
            Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);

            //条件成立+验证不通过
            $params = ['condition' => $nonIntVal, 'param' => 0];
            $this->_assertThrowExpection(function () use ($params) {
                Validation::validate($params, ['param' => "IfStrNotIn:condition,,abc,-100,-1,0,1,100|IntEq:1"]);
            }, 'line ' . __LINE__ . ": 应该抛出异常");
        }
    }

    // 测试对条件参数不存在的情况的处理
    public function testIfConditionParamExistance()
    {
        // 非增量更新 + 条件参数不存在 + 参数存在 -> 应该抛出异常
        $params = [/*'condition' => 1, */
            'param' => 1];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['param' => "IfIntEq:condition,1|IntEq:1"], false);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 非增量更新 + 条件参数不存在 + 参数不存在 -> 应该抛出异常
        $params = [/*'condition' => 1, 'param' => 1*/];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['param' => "IfIntEq:condition,1|IntEq:1"], false);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 增量更新 + 条件参数不存在 + 参数存在 -> 应该抛出异常
        $params = [/*'condition' => 1, */
            'param' => 1];
        $this->_assertThrowExpection(function () use ($params) {
            Validation::validate($params, ['param' => "IfIntEq:condition,1|IntEq:1"], true);
        }, 'line ' . __LINE__ . ": 应该抛出异常");

        // 增量更新 + 条件参数不存在 + 参数不存在 -> 无需检测该参数
        $params = [/*'condition' => 1, 'param' => 1*/];
        Validation::validate($params, ['param' => "IfIntEq:condition,1|IntEq:1"], true);

    }

    public function testValidateIf()
    {
        // 测试条件检测的应用
        $articleInfo = [
            'type' => 1, // 1-普通文章, 2-用户投诉
            'title' => 'WebGeeker Validation',
            'content' => 'WebGeeker Validation 是一个非常强大的参数验证工具, 能够验证无限嵌套的数据结构',
            'state' => 0,
        ];
        $complaintInfo = [
            'type' => 2, // 1-普通新闻, 2-用户投诉
            'title' => '客服（10000）的服务太差了',
            'content' => '客服（10000）的服务太差了, 我要投诉他, 砸他饭碗',
            'state' => 1, // 0-待处理, 1-处理中, 2-已处理
        ];
        $validations = [
            'type' => 'Required|IntIn:1,2',
            'title' => 'Required|StrLenGeLe:2,100',
            'content' => 'Required|StrLenGe:1|StrLenLe:10000000',
            'state' => [
                'IfIntEq:type,1|IntEq:0', // 检测 type===1 普通文章
                'IfIntEq:type,2|Required|IntIn:0,1,2', // 检测 type===2 用户投诉
            ],
        ];
        Validation::validate($articleInfo, $validations);
        Validation::validate($complaintInfo, $validations);

        // 嵌套的条件检测
        $validations2 = [
            'article.type' => 'Required|IntIn:1,2',
            'article.title' => 'Required|StrLenGeLe:2,100',
            'article.content' => 'Required|StrLenGe:1|StrLenLe:10000000',
            'article.state' => [
                'IfIntEq:.type,1|IntEq:0', // 条件参数采用相对路径
                'IfIntEq:article.type,2|Required|IntIn:0,1,2', // 条件参数采用绝对路径
            ],
        ];
        Validation::validate(['article' => $articleInfo], $validations2);
        Validation::validate(['article' => $complaintInfo], $validations2);
    }

    public function testValidate()
    {
        $params = [
            'id' => 1,
            'title' => 'WebGeeker Validation',
            'content' => 'WebGeeker Validation 是一个非常强大的参数验证工具, 能够验证无限嵌套的数据结构',
            'timestamp' => 1491127037.37,
            'contentType' => 0, // 内容类型. 0-html, 1-txt, 2-markdown
            'author' => [
                'id' => 1,
                'username' => 'photondragon',
                'nickname' => '迷途老码',
                'email' => 'photondragon@163.com',
            ],
            'comments' => [
                [
                    'content' => 'webgeeker/validation 棒棒哒',
                    'author' => [
                        'email' => 'admin@webgeeker.com',
                        'nickname' => '阿达明',
                    ],
                ],
                [
                    'content' => 'webgeeker/validation is amazing!',
                ],
            ],
        ];

        $validators = [
            'id' => 'Required|IntGt:0',
            'title' => 'Required|StrLenGeLe:2,100',
            'content' => 'Required|StrLenGe:1|StrLenLe:10000000',
            'timestamp' => 'FloatGt:0',
            'contentType' => 'Required|IntIn:0,1,2',
            'author' => 'Required|Obj',
            'author.id' => 'Required|IntGt:0',
            'author.username' => 'Required|StrLenGe:4|Regexp:/^[a-zA-Z0-9]+$/',
            'author.nickname' => 'StrLenGe:0',
            'author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments' => 'Arr',
            'comments[*]' => 'Obj',
            'comments[*].content' => 'Required|StrLenGe:8',
            'comments[*].author' => 'Obj',
            'comments[*].author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments[*].author.nickname' => 'StrLenGe:0',
            'visitors' => 'Arr',
            'visitors[*]' => 'Obj',
            'visitors[*].id' => 'Required|IntGt:0',
        ];

        $this->assertNotNull(Validation::validate($params, []));
        $this->assertNotNull(Validation::validate($params, $validators));

        // ignore Required
        $params = ['content' => null];
        $validators = ['content' => 'Required|StrLenLe:20',];
        $this->_assertThrowExpection(function () use ($params, $validators) {
            Validation::validate($params, $validators);
        }, 'line ' . __LINE__ . ": Validation::validate(\$params, \$validators)应该抛出异常");
        $this->assertNotNull(Validation::validate($params, $validators, true));

        // ignore Required 2
        $params = ['content' => 'a'];
        $validators = ['content' => 'Required|StrLenGeLe:1,20',];
        $this->assertNotNull(Validation::validate($params, $validators));
        $params = ['content' => null];
        $this->assertNotNull(Validation::validate($params, $validators, true));
    }

    public function testValidateI18n()
    {
        // ============================================================
        // 旧的“错误描述信息模版”的翻译
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("");
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int", // 没有Alias，不翻译
            ]);
        }, '“var”必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("abc"); // 设置了一个无效的lang code，结果就是不翻译
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, '“var”必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw"); // 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, '“var”必須是整數');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("en-us"); // 将翻译为英语（美国）
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, 'var must be a integer');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw");// 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Arr",  // 但是翻译表中没有提供翻译文本，所以结果是不翻译
            ]);
        }, '“var”必须是数组');

        // ============================================================
        // 新的“错误描述信息模版”的翻译
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation2::setLangCode("");
            MyValidation2::validate(["var" => 1.0], [
                "var" => "Int", // 没有Alias，不翻译
            ]);
        }, '“var”必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation2::setLangCode("abc"); // 设置了一个无效的lang code，结果就是不翻译
            MyValidation2::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, '“var”必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation2::setLangCode("zh-tw"); // 将翻译为繁体中文
            MyValidation2::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, '“var”必須是整數');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation2::setLangCode("en-us"); // 将翻译为英语（美国）
            MyValidation2::validate(["var" => 1.0], [
                "var" => "Int",
            ]);
        }, 'var must be an integer');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation2::setLangCode("zh-tw");// 将翻译为繁体中文
            MyValidation2::validate(["var" => 1.0], [
                "var" => "Arr",  // 但是翻译表中没有提供翻译文本，所以结果是不翻译
            ]);
        }, '“var”必须是数组');

        // ============================================================
        // （由Alias指定的）参数名称的翻译
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("");
            MyValidation::validate(["var" => 1.0], [
                "var" => "Obj", // 没有Alias，不翻译
            ]);
        }, '“var”必须是对象');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("abc"); // 设置了一个无效的lang code，结果就是不翻译
            MyValidation::validate(["var" => 1.0], [
                "var" => "Obj|Alias:变量",
            ]);
        }, '“变量”必须是对象');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw"); // 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Obj|Alias:变量",
            ]);
        }, '“變量”必须是对象');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("en-us"); // 将翻译为英语（美国）
            MyValidation::validate(["var" => 1.0], [
                "var" => "Obj|Alias:变量",
            ]);
        }, '“variable”必须是对象');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw");// 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Obj|Alias:可变量",  // 但是翻译表中没有提供“可变量”的翻译文本，所以结果是不翻译
            ]);
        }, '“可变量”必须是对象');

        // ============================================================
        // （由“>>>”指定的）错误描述的翻译
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("");
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int", // 没有>>>，不翻译
            ]);
        }, '“var”必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("abc"); // 设置了一个无效的lang code，结果就是不翻译
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int|>>>:变量必须是整数",
            ]);
        }, '变量必须是整数');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw"); // 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int|>>>:变量必须是整数",
            ]);
        }, '變量必須是整數');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("en-us"); // 将翻译为英语（美国）
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int|>>>:变量必须是整数",
            ]);
        }, 'variable must be an integer');
        $this->_assertThrowExpectionContainErrorString(function () {
            MyValidation::setLangCode("zh-tw");// 将翻译为繁体中文
            MyValidation::validate(["var" => 1.0], [
                "var" => "Int|>>>:可变量必须是整数",  // 但是翻译表中没有提供“可变量必须是整数”的翻译文本，所以结果是不翻译
            ]);
        }, '可变量必须是整数');

    }
}