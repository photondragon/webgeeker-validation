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
        if(is_callable($callback) === false)
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

        // IntEquals
        $this->assertNotNull(Validation::validateIntEquals('-1', -1));

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

        // IntGeAndLe
        $this->assertNotNull(Validation::validateIntGeAndLe('0', 0, 0));
        $this->assertNotNull(Validation::validateIntGeAndLe(0, 0, 0));
        $this->assertNotNull(Validation::validateIntGeAndLe('11', -100, 100));
        $this->assertNotNull(Validation::validateIntGeAndLe(11, -100, 100));
        $this->assertNotNull(Validation::validateIntGeAndLe('00123', 123, 123));

        // IntGtAndLt
        $this->assertNotNull(Validation::validateIntGtAndLt('0', -1, 1));
        $this->assertNotNull(Validation::validateIntGtAndLt(0, -1, 1));

        // IntGtAndLe
        $this->assertNotNull(Validation::validateIntGtAndLe('0', -1, 0));
        $this->assertNotNull(Validation::validateIntGtAndLe(0, -1, 0));

        // IntGeAndLt
        $this->assertNotNull(Validation::validateIntGeAndLt('0', 0, 1));
        $this->assertNotNull(Validation::validateIntGeAndLt(0, 0, 1));

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
        $this->assertNotNull(Validation::validateFloatGtAndLt('10.', -100, 100));
    }

    public function testValidateString()
    {
        $this->assertNotNull(Validation::validateString('-12311112311111'));
        $this->assertNotNull(Validation::validateLengthGe('10.', 0));

        $this->assertNotNull(Validation::validateEmail('photondragon@163.com'));
        $this->assertNotNull(Validation::validateUrl('http://webgeeker.com'));
        $this->assertNotNull(Validation::validateIp('10.1.1.1'));
        $this->assertNotNull(Validation::validateMac('0a:32:dc:02:2f:0a'));
    }

    public function testValidateRegexp()
    {
        $this->assertNotNull(Validation::validateRegexp('10.', '/^[0-9.]+$/', '这是原因'));
        $this->assertNotNull(Validation::validateRegexp('10/abcd', '/^[0-9]+\/abcd$/'));
    }

    public function testValidateArray()
    {
        $this->assertNotNull(Validation::validateArray([]));
        $this->assertNotNull(Validation::validateArray([1,2,3]));
        $this->_assertThrowExpection(function () {
            Validation::validateArray(1);
        }, 'line ' . __LINE__ . ": Validation::validateArray(1)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateArray(['a'=>1]);
        }, 'line ' . __LINE__ . ": Validation::validateArray(['a'=>1])应该抛出异常");

        $this->assertNotNull(Validation::validateArrayLength([1,2,3], 3));
        $this->assertNotNull(Validation::validateArrayLengthGe([1,2,3], 3));
        $this->assertNotNull(Validation::validateArrayLengthLe([1,2,3], 3));
        $this->assertNotNull(Validation::validateArrayLengthGeAndLe([1,2,3], 3, 3));
    }

    public function testValidateObject()
    {
        $this->assertNotNull(Validation::validateObject([]));
        $this->assertNotNull(Validation::validateObject(['a'=>1]));
        $this->_assertThrowExpection(function () {
            Validation::validateObject(1.23);
        }, 'line ' . __LINE__ . ": Validation::validateObject(1.23)应该抛出异常");
        $this->_assertThrowExpection(function () {
            Validation::validateObject([1,2,3]);
        }, 'line ' . __LINE__ . ": Validation::validateObject([1,2,3])应该抛出异常");
    }

    public function testValidateFile()
    {
    }

    public function testValidateOthers()
    {
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
            'title' => 'Required|LengthGeAndLe:2,100',
            'content' => 'Required|LengthGe:1|LengthLe:10000000',
            'timestamp' => 'FloatGt:0',
            'contentType' => 'Required|IntIn:0,1,2',
            'author' => 'Required|Object',
            'author.id' => 'Required|IntGt:0',
            'author.username' => 'Required|LengthGe:4|Regexp:/^[a-zA-Z0-9]+$/',
            'author.nickname' => 'LengthGe:0',
            'author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments' => 'Array',
            'comments[*]' => 'Object',
            'comments[*].content' => 'Required|LengthGe:8',
            'comments[*].author' => 'Object',
            'comments[*].author.email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
            'comments[*].author.nickname' => 'LengthGe:0',
            'visitors' => 'Array',
            'visitors[*]' => 'Object',
            'visitors[*].id' => 'Required|IntGt:0',
        ];
        
        $this->assertNotNull(Validation::validate($params, []));
        $this->assertNotNull(Validation::validate($params, $validators));

        // ignore Required
        $params = ['content' => null];
        $validators = ['content' => 'Required|LengthLe:20',];
        $this->_assertThrowExpection(function () use ($params, $validators) {
            Validation::validate($params, $validators);
        }, 'line ' . __LINE__ . ": Validation::validate(\$params, \$validators)应该抛出异常");
        $this->assertNotNull(Validation::validate($params, $validators, true));

        // ignore Required 2
        $params = ['content' => 'a'];
        $validators = ['content' => 'Required|LengthGeAndLe:1,20',];
        $this->assertNotNull(Validation::validate($params, $validators));
        $params = ['content' => null];
        $this->assertNotNull(Validation::validate($params, $validators, true));
    }

}