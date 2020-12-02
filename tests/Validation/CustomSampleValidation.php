<?php

namespace WebGeeker\ValidationTest;

use \WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;

/**
 * 自定义验证器示例类Sample
 *
 * 本类实现了以下自定义验证器：
 * CustomStrIn 用于验证参数是否是字符串，并且其取值是指定的几个字符串之一
 */
class CustomSampleValidation extends CustomExampleValidation
{
    /**
     * @var array 验证失败时的错误提示信息的模版。
     *      子类的模版在运行时会与父类的 $errorTemplates 合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $errorTemplates = [
        'CustomStrIn' => '“{{param}}”只能取这些值: {{valueList}}',
    ];

    /**
     * @var \string[][] 文本翻译对照表
     *      子类的文本翻译对照表在运行时会与父类的 $langCodeToTranslations （递归）合并，
     *      如果出现同名的键, 子类的值会覆盖父类的值
     */
    protected static $langCodeToTranslations = [
        "zh-tw" => [
            "状态" => "狀態",
        ],
        "en-us" => [
            "状态" => "status",
        ],
    ];

    /**
     * 自定义验证器"CustomStrIn"的参数解析方法
     *
     * 假设验证器为"CustomStrIn:pending,started,success,failed"
     * 则 $paramString = "pending,started,success,failed"
     * 则本函数返回值为（数组的数组）: [
     *     ['pending', 'started', 'success', 'failed']
     * ]
     * 返回"数组的数组"可以实现验证器的参数个数可变。
     *
     * @param $paramString string 验证器的参数
     * @return array 返回解析后的参数的数组。数组的长度就是验证器的
     *        参数个数，必须与对应的 validateCustomStrIn() 方法的参数个数匹配。
     */
    protected static function parseParamsOfCustomStrIn($paramString)
    {
        $list = explode(',', $paramString);
        return [$list]; // 注意这里返回的是数组的数组
    }

    /**
     * 自定义验证器"CustomStrIn"的验证方法的实现
     *
     * @param $value mixed 待验证的值
     * @param $valueList string[] 可取值的列表。
     *        对应上面的 parseParamsOfCustomStrIn() 方法返回的数组的第0个元素($list)
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 需要自动生成
     * @param $alias string 参数别名, 用于错误提示。
     * @return mixed 返回参数 $value 的原值
     * @throws ValidationException 验证失败抛出异常
     */
    public static function validateCustomStrIn($value, $valueList, $reason, $alias)
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new ValidationException("“${alias}”参数的验证模版(StrIn:)格式错误, 必须提供可取值的列表");

        if (is_string($value)) {
            if (in_array($value, $valueList, true))
                return $value;
            $isTypeError = false;
        } else
            $isTypeError = true;

        if ($reason !== null)
            throw new ValidationException($reason);

        if ($isTypeError) {
            $error = '“{{param}}”必须是Custom字符串';
            $error = str_replace('{{param}}', $alias, $error);
        } else {
            $error = self::getErrorTemplate('CustomStrIn');
            $error = str_replace('{{param}}', $alias, $error);
            $error = str_replace('{{valueList}}', '"'.implode('", "', $valueList).'"', $error);
        }

        throw new ValidationException($error);
    }

}