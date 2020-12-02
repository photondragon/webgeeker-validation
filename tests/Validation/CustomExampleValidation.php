<?php

namespace WebGeeker\ValidationTest;

use \WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;

/*
 * 自定义验证器的参数解析方法
 *
 * 如果自定义验证器没有提供参数解析方法，则使用默认的参数解析方法：
 *     explode(',', $paramString)
 * 默认的参数解析方法的缺点：
 * 1. 解析出来的参数只会是字符串
 * 2. 不会检测验证器参数的合法性
 * 3. 验证器参数无法使用逗号，因为逗号是做为参数分隔符来处理的。
 * 4. 无法支持验证器的参数个数可变
 *
 * 解决以上问题的方法就是提供"自定义验证器的参数解析方法"
 *
 */
/**
 * 自定义验证器示例类Example
 *
 * 本类实现了以下自定义验证器：
 * CustomFloatGtLt 用于验证参数是否是浮点数，并且其值在(min, max)之间
 */
class CustomExampleValidation extends CustomDemoValidation
{
    /**
     * @var array 验证失败时的错误提示信息的模版。
     *      子类的模版在运行时会与父类的 $errorTemplates 合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $errorTemplates = [
        'CustomFloatGtLt' => '“{{param}}”必须大于 {{min}} 小于 {{max}}',
    ];

    /**
     * @var \string[][] “错误提示信息模版” $errorTemplates 的翻译对照表
     *      子类的翻译对照表在运行时会与父类的 $langCode2ErrorTemplates （递归）合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $langCode2ErrorTemplates = [
        "zh-tw" => [
            'CustomFloatGtLt' => '“{{param}}”必須大於 {{min}} 小於 {{max}}',
        ],
        "en-us" => [
            'CustomFloatGtLt' => '{{param}} must be greater than {{min}} and less than {{max}}',
        ],
    ];

    /**
     * 自定义验证器"CustomFloatGtLt"的参数解析方法
     *
     * 假设验证器为"CustomFloatGtLt:1.0,10"
     * 则 $paramString = "1.0,10"
     * 本函数返回值为: [1.0, 10.0]
     *
     * @param $paramString string 验证器的参数
     * @return array 返回解析后的参数的数组。数组的长度就是验证器的
     *        参数个数，必须与对应的 validateCustomFloatGtLt() 方法的参数个数匹配。
     * @throws ValidationException 参数解析失败抛出异常
     */
    protected static function parseParamsOfCustomFloatGtLt($paramString)
    {
        $vals = explode(',', $paramString);
        if (count($vals) !== 2)
            throw new ValidationException("自定义验证器 CustomFloatGtLt 格式错误. 正确格式示例: CustomFloatGtLt:1.0,2.0");
        $p1 = $vals[0];
        $p2 = $vals[1];
        if (is_numeric($p1) === false || is_numeric($p2) === false)
            throw new ValidationException("自定义验证器 CustomFloatGtLt 参数类型错误. 正确的示例: CustomFloatGtLt:1.0,2.0");
        return [$p1, $p2];
    }

    /**
     * 自定义验证器"CustomFloatGtLt"的验证方法的实现
     *
     * @param $value mixed 待验证的值
     * @param $min float 最小值。对应上面的 parseParamsOfCustomFloatGtLt() 方法
     *        返回的数组的第0个元素($p1)
     * @param $max float 最大值。对应上面的 parseParamsOfCustomFloatGtLt() 方法
     *        返回的数组的第1个元素($p2)
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     * @param $alias string 参数别名, 用于错误提示。
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
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
            $error = '“{{param}}”必须是浮点数';
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomFloatGtLt');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{min}}', $min, $error);
            $error = str_replace('{{max}}', $max, $error);
        }
        throw new ValidationException($error);
    }

}