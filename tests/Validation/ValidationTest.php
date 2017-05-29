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

    public function testValidateInt()
    {
        // Int
        $this->assertNotNull(Validation::validateInt('-1'));
        $this->assertNotNull(Validation::validateInt('0'));
        $this->assertNotNull(Validation::validateInt('1'));
        $this->assertNotNull(Validation::validateInt(-1));
        $this->assertNotNull(Validation::validateInt(0));
        $this->assertNotNull(Validation::validateInt(1));
        $this->_assertThrowExpection(function () {
            Validation::validateInt(true);
        }, 'line ' . __LINE__ . ": Validation::validateInt(true)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateInt([]);
        }, 'line ' . __LINE__ . ": Validation::validateInt([])应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateInt(0.0);
        }, 'line ' . __LINE__ . ": Validation::validateInt(0.0)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateInt('abc');
        }, 'line ' . __LINE__ . ": Validation::validateInt('abc')应该抛出异常");

        // IntEq
        $this->assertNotNull(Validation::validateIntEq('-1', -1));

        // IntGt
        $this->assertNotNull(Validation::validateIntGt('1', 0));
        $this->_assertThrowExpection(function () {
            Validation::validateIntGt('0', 0);
        }, 'line ' . __LINE__ . ": Validation::validateIntGt('0', 0)应该抛出异常");
        $this->assertNotNull(Validation::validateIntGt(1, 0));
        $this->_assertThrowExpection(function () {
            Validation::validateIntGt(0, 0);
        }, 'line: ' . __LINE__ . ": Validation::validateIntGt(0, 0)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateIntGt(false, 0);
        }, 'line: ' . __LINE__ . ": Validation::validateIntGt(false, 0)应该抛出异常");

        // IntGe
        $this->assertNotNull(Validation::validateIntGe('1', 0));
        $this->assertNotNull(Validation::validateIntGe('0', 0));
        $this->assertNotNull(Validation::validateIntGe(1, 0));
        $this->assertNotNull(Validation::validateIntGe(0, 0));

        // IntLt
        $this->assertNotNull(Validation::validateIntLt('-1', 0));
        $this->_assertThrowExpection(function () {
            Validation::validateIntLt('0', 0);
        }, 'line ' . __LINE__ . ": Validation::validateIntLt('0', 0)应该抛出异常");
        $this->assertNotNull(Validation::validateIntLt(-1, 0));
        $this->_assertThrowExpection(function () {
            Validation::validateIntLt(0, 0);
        }, 'line: ' . __LINE__ . ": Validation::validateIntLt(0, 0)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateIntLt(false, 0);
        }, 'line: ' . __LINE__ . ": Validation::validateIntLt(false, 0)应该抛出异常");

        // IntLe
        $this->assertNotNull(Validation::validateIntLe('-1', 0));
        $this->assertNotNull(Validation::validateIntLe(-1, 0));
        $this->assertNotNull(Validation::validateIntLe('0', 0));
        $this->assertNotNull(Validation::validateIntLe(0, 0));

        // IntGeLe
        $this->assertNotNull(Validation::validateIntGeLe('0', 0, 0));
        $this->assertNotNull(Validation::validateIntGeLe(0, 0, 0));
        $this->assertNotNull(Validation::validateIntGeLe('11', -100, 100));
        $this->assertNotNull(Validation::validateIntGeLe(11, -100, 100));
        $this->assertNotNull(Validation::validateIntGeLe('00123', 123, 123));

        // IntGtLt
        $this->assertNotNull(Validation::validateIntGtLt('0', -1, 1));
        $this->assertNotNull(Validation::validateIntGtLt(0, -1, 1));

        // IntGtLe
        $this->assertNotNull(Validation::validateIntGtLe('0', -1, 0));
        $this->assertNotNull(Validation::validateIntGtLe(0, -1, 0));

        // IntGeLt
        $this->assertNotNull(Validation::validateIntGeLt('0', 0, 1));
        $this->assertNotNull(Validation::validateIntGeLt(0, 0, 1));

        // IntIn
        $this->assertNotNull(Validation::validateIntIn('0', [0, 1]));
        $this->assertNotNull(Validation::validateIntIn(0, [0, 1]));

        // IntNotIn
        $this->assertNotNull(Validation::validateIntNotIn('-1', [0, 1]));
        $this->assertNotNull(Validation::validateIntNotIn(-1, [0, 1]));

    }

    public function testValidateFloat()
    {
        $this->assertNotNull(Validation::validateFloat('-12311112311111'));
        $this->assertNotNull(Validation::validateFloatGtLt('10.', -100, 100));
    }

    public function testValidateString()
    {
        // Str
        $this->assertNotNull(Validation::validateValue('-12311112311111', 'Str'));

        // LenXXX
        $this->assertNotNull(Validation::validateValue('你好', 'Len:2'));
        $this->assertNotNull(Validation::validateValue('你好', 'LenGe:2'));
        $this->assertNotNull(Validation::validateValue('你好', 'LenLe:2'));
        $this->assertNotNull(Validation::validateValue('你好', 'LenGeLe:2,2'));

        // ByteLenXXX
        $this->assertNotNull(Validation::validateValue('你好', 'ByteLen:6'));
        $this->assertNotNull(Validation::validateValue('你好', 'ByteLenGe:6'));
        $this->assertNotNull(Validation::validateValue('你好', 'ByteLenLe:6'));
        $this->assertNotNull(Validation::validateValue('你好', 'ByteLenGeLe:6,6'));

        // 各种其它检测
        $this->assertNotNull(Validation::validateValue('photondragon@163.com', 'Email'));
        $this->assertNotNull(Validation::validateValue('http://webgeeker.com', 'Url'));
        $this->assertNotNull(Validation::validateValue('10.10.10.10', 'Ip'));
        $this->assertNotNull(Validation::validateValue('01:32:DC:05:2f:0a', 'Mac'));

    }

    public function testValidateRegexp()
    {
        $this->assertNotNull(Validation::validateRegexp('10.', '/^[0-9.]+$/', '这是原因'));
        $this->assertNotNull(Validation::validateRegexp('10/abcd', '/^[0-9]+\/abcd$/'));
    }

    public function testValidateArray()
    {
        $this->assertNotNull(Validation::validateArray([]));
        $this->assertNotNull(Validation::validateArray([1, 2, 3]));
        $this->_assertThrowExpection(function () {
            Validation::validateArray(1);
        }, 'line ' . __LINE__ . ": Validation::validateArray(1)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateArray(['a' => 1]);
        }, 'line ' . __LINE__ . ": Validation::validateArray(['a'=>1])应该抛出异常");

        $this->assertNotNull(Validation::validateArrayLen([1, 2, 3], 3));
        $this->assertNotNull(Validation::validateArrayLenGe([1, 2, 3], 3));
        $this->assertNotNull(Validation::validateArrayLenLe([1, 2, 3], 3));
        $this->assertNotNull(Validation::validateArrayLenGeLe([1, 2, 3], 3, 3));
    }

    public function testValidateObject()
    {
        $this->assertNotNull(Validation::validateObject([]));
        $this->assertNotNull(Validation::validateObject(['a' => 1]));
        $this->_assertThrowExpection(function () {
            Validation::validateObject(1.23);
        }, 'line ' . __LINE__ . ": Validation::validateObject(1.23)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateObject([1, 2, 3]);
        }, 'line ' . __LINE__ . ": Validation::validateObject([1,2,3])应该抛出异常");
    }

    public function testValidateFile()
    {
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
            Validation::validateValue([1, 2, 3], 'Int|>>>:|>>>:ERROR: 您必须输入一个整数|Array');
        } catch (\Exception $e) {
            $errstr = $e->getMessage();
            $this->assertEquals('|>>>:ERROR: 您必须输入一个整数|Array', $errstr);
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
            'title' => 'Required|LenGeLe:2,100',
            'content' => 'Required|LenGe:1|LenLe:10000000',
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
            'article.title' => 'Required|LenGeLe:2,100',
            'article.content' => 'Required|LenGe:1|LenLe:10000000',
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
            'title' => 'Required|LenGeLe:2,100',
            'content' => 'Required|LenGe:1|LenLe:10000000',
            'timestamp' => 'FloatGt:0',
            'contentType' => 'Required|IntIn:0,1,2',
            'author' => 'Required|Object',
            'author.id' => 'Required|IntGt:0',
            'author.username' => 'Required|LenGe:4|Regexp:/^[a-zA-Z0-9]+$/',
            'author.nickname' => 'LenGe:0',
            'author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments' => 'Array',
            'comments[*]' => 'Object',
            'comments[*].content' => 'Required|LenGe:8',
            'comments[*].author' => 'Object',
            'comments[*].author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments[*].author.nickname' => 'LenGe:0',
            'visitors' => 'Array',
            'visitors[*]' => 'Object',
            'visitors[*].id' => 'Required|IntGt:0',
        ];

        $this->assertNotNull(Validation::validate($params, []));
        $this->assertNotNull(Validation::validate($params, $validators));

        // ignore Required
        $params = ['content' => null];
        $validators = ['content' => 'Required|LenLe:20',];
        $this->_assertThrowExpection(function () use ($params, $validators) {
            Validation::validate($params, $validators);
        }, 'line ' . __LINE__ . ": Validation::validate(\$params, \$validators)应该抛出异常");
        $this->assertNotNull(Validation::validate($params, $validators, true));

        // ignore Required 2
        $params = ['content' => 'a'];
        $validators = ['content' => 'Required|LenGeLe:1,20',];
        $this->assertNotNull(Validation::validate($params, $validators));
        $params = ['content' => null];
        $this->assertNotNull(Validation::validate($params, $validators, true));
    }

}