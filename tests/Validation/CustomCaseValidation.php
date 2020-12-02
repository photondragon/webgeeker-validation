<?php

namespace WebGeeker\ValidationTest;

use \WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;

/*
 * 如何实现自定义验证器：
 * 1. 自定义验证器必须以"Custom"开头，比如"CustomAbc"、"CustomXyz"
 * 1. 定义一个类，继承`\WebGeeker\Validation\Validation`
 * 2. 在该类中提供"自定义验证器的实现方法"，有几个验证器，就提供几个实现方法。
 *
 * 自定义验证器的实现方法的格式示例：
 * public static function validateCustomAbc($value, $reason, $alias){
 *     // ...
 * }
 *
 * 自定义验证器的实现方法的具体要求：
 * 1. 方法必须以"validate"开头，后面加上验证器名称。
 * 2. 如果自定义验证器没有参数，其实现方法的格式为：
 *    public static function validateCustomAbc($value, $reason, $alias){}
 *    方法有 3 个参数：
 *    $value 待验证的值
 *    $reason 验证失败的错误提示字符串。它的值就是伪验证器">>>"提供的字符串
 *    $alias 参数别名，用于错误提示。它的值等于伪验证器"Alias"提供的字符串
 * 3. 如果自定义验证器有n个参数，那么它的验证方法应该有 3 + n 个参数，
 *    多出来的 n 个参数应该跟在参数 $value 的后面。
 *    带1个参数的验证器示例："CustomStartWith:head"
 *    带多个参数的验证器示例："CustomStrIn:started,success,failed"，多个参数用逗号分隔
 * 4. 如果验证通过，应该返回$value参数的原始值
 * 5. 如果验证失败，应该抛出异常
 */

/**
 * 自定义验证器示例类
 *
 * 本类实现了以下自定义验证器：
 * CustomStartWith 用于验证参数是否以指定前缀开头
 *
 */
class CustomCaseValidation extends Validation
{
    /**
     * @var array 验证失败时的错误提示信息的模版。
     *      子类的模版在运行时会与父类的 $errorTemplates 合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $errorTemplates = [
        'CustomStartWith' => '“{{param}}”必须以"{{prefix}}"开头"',
    ];

    /**
     * 自定义验证器"CustomStartWith"的实现方法，验证输入参数 $value 是否以指定前缀开头
     *
     * @param $value string 待验证的值
     * @param $prefix string 前缀。如果验证器为"CustomStartWith:head"，则本参数的值为"head"
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     *        如果验证中包含了伪验证器">>>:some reason"，本参数值为"some reason"，
     *        如果没有提供伪验证器">>>"，本参数值为null
     * @param $alias string 参数别名, 用于错误提示。
     *        如果验证中包含了伪验证器"Alias:姓名"，则本参数值为"姓名"
     *        如果没有提供"Alias"，比如"name" => "StrLenGeLe:2,30"，本参数值为"name"
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
    public static function validateCustomStartWith($value, $prefix, $reason, $alias)
    {
        if (strpos(strval($value), $prefix) === 0)
            return $value;

        if ($reason !== null)
            throw new ValidationException($reason);

        $error = self::getErrorTemplate('CustomStartWith'); // 获取错误提示信息模版
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{prefix}}', $prefix, $error);
        throw new ValidationException($error);
    }
}