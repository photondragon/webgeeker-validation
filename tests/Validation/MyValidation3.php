<?php

namespace WebGeeker\ValidationTest;

class MyValidation3 extends CustomSampleValidation
{
    // “错误提示信息模版”翻译对照表
    protected static $langCode2ErrorTemplates = [
        "zh-tw" => [
            'CustomInt' => '“{{param}}”必須是Custom整數',
            'CustomStrIn' => '“{{param}}”只能取這些值: {{valueList}}',
        ],
        "en-us" => [
            'CustomInt' => '{{param}} must be an custom integer',
            'CustomStrIn' => '{{param}} can only take these values: {{valueList}}',
        ],
    ];

    // 文本翻译对照表
    protected static $langCodeToTranslations = [
        "zh-tw" => [
            "自定义变量必须是整数" => "自定義變量必須是整數",
        ],
        "en-us" => [
            "自定义变量必须是整数" => "custom variable must be an integer",
        ],
    ];

}