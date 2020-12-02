<?php

namespace WebGeeker\ValidationTest;

use \WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;

/**
 * 自定义验证器示例类Demo
 *
 * 本类实现了以下自定义验证器：
 * CustomInt 用于验证参数是否是整数
 * CustomIntEq 用于验证参数是否是整数，并且与指定数值相等
 * CustomIntGeLe 用于验证参数是否是整数，并且其值在[min, max]之间
 */
class CustomDemoValidation extends CustomCaseValidation
{
    /**
     * @var array 验证失败时的错误提示信息的模版。
     *      子类的模版在运行时会与父类的 $errorTemplates 合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $errorTemplates = [
        'CustomInt' => '“{{param}}”必须是Custom整数',
        'CustomIntEq' => '“{{param}}”必须等于 {{value}}',
        'CustomIntGeLe' => '“{{param}}”必须大于等于 {{min}} 小于等于 {{max}}',
    ];

    /**
     * 自定义验证器"CustomInt"的实现方法
     *
     * @param $value string 待验证的值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     * @param $alias string 参数别名, 用于错误提示。
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
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

    /**
     * 自定义验证器"CustomIntEq"的实现方法。
     * 检测 $value 与 $equalVal 是否相等。
     *
     * @param $value string 待验证的值
     * @param $equalVal string 要比较的值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     * @param $alias string 参数别名, 用于错误提示。
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
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

    /**
     * 自定义验证器"CustomIntGeLe"的实现方法。
     * 检测 $value 取值是否在[$min, $max]之间。
     *
     * @param $value string 待验证的值
     * @param $min string 最小值
     * @param $max string 最大值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     * @param $alias string 参数别名, 用于错误提示。
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
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

}