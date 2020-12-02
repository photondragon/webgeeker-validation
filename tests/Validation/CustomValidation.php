<?php
/*
 * Project: webgeeker-validation
 * File: CustomValidation.php
 * CreateTime: 2020/11/30 20:01
 * Author: photondragon
 * Email: photondragon@163.com
 */

namespace WebGeeker\ValidationTest;

use \WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;

/**
 * @class CustomValidation
 * @package WebGeeker\RestTest
 * @brief 测试自定义验证器功能
 *
 * elaborate description
 */
class CustomValidation extends Validation
{
    /**
     * @var array 验证失败时的错误提示信息的模板
     *
     * 输入值一般为字符串
     */
    protected static $errorTemplates = [
        // 整型（不提供length检测,因为负数的符号位会让人混乱, 可以用大于小于比较来做到这一点）
        'CustomInt' => '“{{param}}”必须是Custom整数',
        'CustomIntEq' => '“{{param}}”必须等于 {{value}}',
        'CustomIntGeLe' => '“{{param}}”必须大于等于 {{min}} 小于等于 {{max}}',
        'CustomFloat' => '“{{param}}”必须是浮点数',
        'CustomFloatGtLt' => '“{{param}}”必须大于 {{min}} 小于 {{max}}',
        'CustomStr' => '“{{param}}”必须是Custom字符串',
        'CustomStrEq' => '“{{param}}”必须等于"{{value}}"',
    ];

    public static function validateCustomInt($value, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false)
                return $value;
        } elseif ($type === 'integer') {
            return $value;
        }

        if ($reason !== null)
            throw new ValidationException($reason);

        $error = self::getErrorTemplate('CustomInt');
        $error = str_replace('{{param}}', $alias, $error);
        throw new ValidationException($error);
    }

    public static function validateCustomIntNoErrorTemplate($value, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false)
                return $value;
        } elseif ($type === 'integer') {
            return $value;
        }

        if ($reason !== null)
            throw new ValidationException($reason);

        $error = self::getErrorTemplate('CustomIntNoErrorTemplate');
        $error = str_replace('{{param}}', $alias, $error);
        throw new ValidationException($error);
    }

    public static function validateCustomIntEq($value, $equalVal, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val == $equalVal)
                    return $value;
                $isTypeError = false;
            } else
                $isTypeError = true;
        } elseif ($type === 'integer') {
            if ($value == $equalVal)
                return $value;
            $isTypeError = false;
        } else
            $isTypeError = true;

        if ($reason !== null)
            throw new ValidationException($reason);

        if ($isTypeError) {
            $error = self::getErrorTemplate('CustomInt');
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomIntEq');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{value}}', $equalVal, $error);
        }
        throw new ValidationException($error);
    }

    public static function validateCustomIntGeLe($value, $min, $max, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val >= $min && $val <= $max)
                    return $value;
                $isTypeError = false;
            } else
                $isTypeError = true;
        } elseif ($type === 'integer') {
            if ($value >= $min && $value <= $max)
                return $value;
            $isTypeError = false;
        } else
            $isTypeError = true;

        if ($reason !== null)
            throw new ValidationException($reason);

        if ($isTypeError) {
            $error = self::getErrorTemplate('CustomInt');
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomIntGeLe');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{min}}', $min, $error);
            $error = str_replace('{{max}}', $max, $error);
        }
        throw new ValidationException($error);
    }

    public static function validateCustomFloat($value, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value))
                return $value;
        } elseif ($type === 'double' || $type === 'integer')
            return $value;

        if ($reason !== null)
            throw new ValidationException($reason);

        $error = self::getErrorTemplate('CustomFloat');
        $error = str_replace('{{param}}', $alias, $error);
        throw new ValidationException($error);
    }

    /**
    // 验证器 CustomFloatGtLt 的参数解析器（可以不实现）
     * @param $validatorParamString string 验证器的参数字符串。比如验证器"IntGtLt:1,3"，本参数的值会是"1,3"
     * @return array 返回解析后的参数的数组。数组的长度就是参数个数，必须与对应的 validateCustomFloatGtLt() 方法的参数个数匹配。
     * @throws ValidationException 参数解析失败抛出异常
     */
    protected static function parseParamsOfCustomFloatGtLt($validatorParamString)
    {
        $vals = explode(',', $validatorParamString);
        if (count($vals) < 2) // 这里写法是错的，是为了测试故意写错的
            throw new ValidationException("自定义验证器 CustomFloatGtLt 格式错误. 正确格式示例: CustomFloatGtLt:1.0,2.0");
        $p1 = $vals[0];
        $p2 = $vals[1];
        if (is_numeric($p1) === false || is_numeric($p2) === false)
            throw new ValidationException("自定义验证器 CustomFloatGtLt 参数类型错误. 正确的示例: CustomFloatGtLt:1.0,2.0");
        $vals[0] = doubleval($p1);
        $vals[1] = doubleval($p2);
        return $vals;
    }
    
    public static function validateCustomFloatGtLt($value, $min, $max, $reason, $alias)
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value)) {
                $val = floatval($value);
                if ($val > $min && $val < $max)
                    return $value;
                $isTypeError = false;
            } else
                $isTypeError = true;
        } elseif ($type === 'double' || $type === 'integer') {
            if ($value > $min && $value < $max)
                return $value;
            $isTypeError = false;
        } else
            $isTypeError = true;

        if ($reason !== null)
            throw new ValidationException($reason);

        if ($isTypeError) {
            $error = self::getErrorTemplate('CustomFloat');
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomFloatGtLt');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{min}}', $min, $error);
            $error = str_replace('{{max}}', $max, $error);
        }
        throw new ValidationException($error);
    }

    public static function validateCustomStr($value, $reason, $alias)
    {
        if (is_string($value)) {
            return $value;
        }

        if ($reason !== null)
            throw new ValidationException($reason);

        $error = self::getErrorTemplate('CustomStr');
        $error = str_replace('{{param}}', $alias, $error);
        throw new ValidationException($error);
    }

    public static function validateCustomStrEq($value, $equalsValue, $reason, $alias)
    {
        if (is_string($value)) {
            if ($value === $equalsValue)
                return $value;
            $isTypeError = false;
        } else
            $isTypeError = true;

        if ($reason !== null)
            throw new ValidationException($reason);

        if ($isTypeError) {
            $error = self::getErrorTemplate('CustomStr');
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomStrEq');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{value}}', $equalsValue, $error);
        }
        throw new ValidationException($error);
    }

}