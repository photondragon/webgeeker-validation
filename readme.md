# WebGeeker-Validation: 参数验证神器
一个强大的参数验证工具, 能够验证无限嵌套的数据结构。

特点
1. 简洁，验证逻辑一目了然
1. 轻量，不需要额外定义各种验证classes
1. 数据类型明确无歧义
1. 支持正则表达式验证
1. 支持条件验证
1. 支持一个参数可以是多种数据类型（虽然不建议使用）
1. 理论上能够支持验证无限嵌套的数据结构

下面这个示例展示了一个查询获取用户投诉列表的Request参数的验证（用到了条件验证和针对嵌套数据结构的验证）：

```php
//验证规则
$validations = [
    "offset" => "IntGe:0", // 参数offset应该大于等于0
    "count" => "Required|IntGeLe:1,200", // 参数count是必需的且大于等于1小于等于200
    "type" => "IntIn:1,2", // 参数type可取值为: 1, 2
    "state" => [
        'IfIntEq:type,1|IntEq:0', // 如果type==1（批评建议），那么参数state只能是0
        'IfIntEq:type,2|IntIn:0,1,2', // 如果type==2（用户投诉），那么参数state可取值为: 1, 2, 3
    ],
    "search.keyword" => "StrLenGeLe:1,100", // search.keyword 应该是一个长度在[1, 100]之间的字符串
    "search.start_time" => "Date", // search.start_time 应该是一个包含合法日期的字符串
    "search.end_time" => "BoolSmart", // search.end_time 应该是一个包含合法日期的字符串
];

// 待验证参数
$params = [
    "offset" => 0, // 从第0条记录开始
    "count" => 10, // 最多返回10条记录
    "type" => 2, // 1-批评建议, 2-用户投诉
    "state" => 0, // 0-待处理, 1-处理中, 2-已处理
    "search" => [ // 搜索条件
        "keyword" => '硬件故障', // 关键字
        "start_time" => "2018-01-01", // 起始日期
        "end_time" => "2018-01-31", // 结束日期
    ],
];

// 验证（如果验证不通过，会抛出异常）
Validation::validate($params, $validations);
```

## 1. 安装

通过Composer安装
```
composer require webgeeker/validation:^0.2
```

## 2. 使用

### 2.1 一个完整的示例（不使用任何框架）

这个例子直接验证`$_GET`中的参数，展示了最基本的用法

```php
<?php
include "vendor/autoload.php";

use WebGeeker\Validation\Validation;

try {
    Validation::validate($_GET, [
        "offset" => "IntGe:0", // 参数offset应该大于等于0
        "count" => "Required|IntGeLe:1,200", // 参数count是必需的且大于等于1小于等于200
    ]);
} catch (\Exception $e) {
    echo $e->getMessage();
}

```

### 2.2 使用第三方框架的用法

第三方框架一般会提供Request对象，可以取到GET, POST参数（以Laravel为例）

```php
//$params = $request->query(); // 获取GET参数
$params = $request->request->all(); // 获取POST参数

// 验证（如果验证不通过，会抛出异常）
Validation::validate($params, [
    // 此处省略验证规则
]);
```

## 3 验证器

### 3.1 整型

| 整型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Int | Int | “{{param}}”必须是整数 |
| IntEq | IntEq:100 | “{{param}}”必须等于 {{value}} |
| IntGt | IntGt:100 | “{{param}}”必须大于 {{min}} |
| IntGe | IntGe:100 | “{{param}}”必须大于等于 {{min}} |
| IntLt | IntLt:100 | “{{param}}”必须小于 {{max}} |
| IntLe | IntLe:100 | “{{param}}”必须小于等于 {{max}} |
| IntGtLt | IntGtLt:1,100 | “{{param}}”必须大于 {{min}} 小于 {{max}} |
| IntGeLe | IntGeLe:1,100 | “{{param}}”必须大于等于 {{min}} 小于等于 {{max}} |
| IntGtLe | IntGtLe:1,100 | “{{param}}”必须大于 {{min}} 小于等于 {{max}} |
| IntGeLt | IntGeLt:1,100 | “{{param}}”必须大于等于 {{min}} 小于 {{max}} |
| IntIn | IntIn:2,3,5,7,11 | “{{param}}”只能取这些值: {{valueList}} |
| IntNotIn | IntNotIn:2,3,5,7,11 | “{{param}}”不能取这些值: {{valueList}} |

### 3.2 浮点型

内部一律使用double来处理

| 浮点型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Float | Float | “{{param}}”必须是浮点数 |
| FloatGt | FloatGt:1.0 | “{{param}}”必须大于 {{min}} |
| FloatGe | FloatGe:1.0 | “{{param}}”必须大于等于 {{min}} |
| FloatLt | FloatLt:1.0 | “{{param}}”必须小于 {{max}} |
| FloatLe | FloatLe:1.0 | “{{param}}”必须小于等于 {{max}} |
| FloatGtLt | FloatGtLt:0,1.0 | “{{param}}”必须大于 {{min}} 小于 {{max}} |
| FloatGeLe | FloatGeLe:0,1.0 | “{{param}}”必须大于等于 {{min}} 小于等于 {{max}} |
| FloatGtLe | FloatGtLe:0,1.0 | “{{param}}”必须大于 {{min}} 小于等于 {{max}} |
| FloatGeLt | FloatGeLt:0,1.0 | “{{param}}”必须大于等于 {{min}} 小于 {{max}} |

### 3.3 bool型

| bool型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Bool | Bool | 合法的取值为: `true`, `false`, `"true"`, `"false"`（忽略大小写） |
| BoolSmart | BoolSmart | 合法的取值为: `true`, `false`, `"true"`, `"false"`, `1`, `0`, `"1"`, `"0"`, `"yes"`, `"no"`, `"y"`, `"n"`（忽略大小写） |

### 3.4 字符串型

| 字符串型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Str | Str | “{{param}}”必须是字符串 |
| StrEq | StrEq:abc | “{{param}}”必须等于"{{value}}" |
| StrEqI | StrEqI:abc | “{{param}}”必须等于"{{value}}"（忽略大小写） |
| StrNe | StrNe:abc | “{{param}}”不能等于"{{value}}" |
| StrNeI | StrNeI:abc | “{{param}}”不能等于"{{value}}"（忽略大小写） |
| StrIn | StrIn:abc,def,g | “{{param}}”只能取这些值: {{valueList}} |
| StrInI | StrInI:abc,def,g | “{{param}}”只能取这些值: {{valueList}}（忽略大小写） |
| StrNotIn | StrNotIn:abc,def,g | “{{param}}”不能取这些值: {{valueList}} |
| StrNotInI | StrNotInI:abc,def,g | “{{param}}”不能取这些值: {{valueList}}（忽略大小写） |
| StrLen | StrLen:8 | “{{param}}”长度必须等于 {{length}} |
| StrLenGe | StrLenGe:8 | “{{param}}”长度必须大于等于 {{min}} |
| StrLenLe | StrLenLe:8 | “{{param}}”长度必须小于等于 {{max}} |
| StrLenGeLe | StrLenGeLe:6,8 | “{{param}}”长度必须在 {{min}} - {{max}} 之间 |
| ByteLen | ByteLen:8 | “{{param}}”长度（字节）必须等于 {{length}} |
| ByteLenGe | ByteLenGe:8 | “{{param}}”长度（字节）必须大于等于 {{min}} |
| ByteLenLe | ByteLenLe:8 | “{{param}}”长度（字节）必须小于等于 {{max}} |
| ByteLenGeLe | ByteLenGeLe:6,8 | “{{param}}”长度（字节）必须在 {{min}} - {{max}} 之间 |
| Letters | Letters | “{{param}}”只能包含字母 |
| Alphabet | Alphabet | 同Letters |
| Numbers | Numbers | “{{param}}”只能是纯数字 |
| Digits | Digits | 同Numbers |
| LettersNumbers | LettersNumbers | “{{param}}”只能包含字母和数字 |
| Numeric | Numeric | “{{param}}”必须是数值。一般用于大数处理（超过double表示范围的数,一般会用字符串来表示）（尚未实现大数处理）, 如果是正常范围内的数, 可以使用'Int'或'Float'来检测 |
| VarName | VarName | “{{param}}”只能包含字母、数字和下划线，并且以字母或下划线开头 |
| Email | Email | “{{param}}”必须是合法的email |
| Url | Url | “{{param}}”必须是合法的Url地址 |
| Ip | Ip | “{{param}}”必须是合法的IP地址 |
| Mac | Mac | “{{param}}”必须是合法的MAC地址 |
| Regexp | Regexp:/^abc$/ | Perl正则表达式匹配 |

### 3.5 数组型

| 数组型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Arr | Arr | “{{param}}”必须是数组 |
| ArrLen | ArrLen:5 | “{{param}}”数组长度必须等于 {{length}} |
| ArrLenGe | ArrLenGe:1 | “{{param}}”数组长度必须大于等于 {{min}} |
| ArrLenLe | ArrLenLe:9 | “{{param}}”数组长度必须小于等于 {{max}} |
| ArrLenGeLe | ArrLenGeLe:1,9 | “{{param}}”长数组度必须在 {{min}} ~ {{max}} 之间 |

### 3.6 对象型

| 对象型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Obj | Obj | “{{param}}”必须是对象 |

### 3.7 文件型

| 文件型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| File | File | “{{param}}”必须是文件 |
| FileMaxSize | FileMaxSize:10mb | “{{param}}”必须是文件, 且文件大小不超过{{size}} |
| FileMinSize | FileMinSize:100kb | “{{param}}”必须是文件, 且文件大小不小于{{size}} |
| FileImage | FileImage | “{{param}}”必须是图片 |
| FileVideo | FileVideo | “{{param}}”必须是视频文件 |
| FileAudio | FileAudio | “{{param}}”必须是音频文件 |
| FileMimes | FileMimes:mpeg,jpeg,png | “{{param}}”必须是这些MIME类型的文件:{{mimes}} |

### 3.8 日期和时间型

| 日期和时间型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Date | Date | “{{param}}”必须符合日期格式YYYY-MM-DD |
| DateFrom | DateFrom:2017-04-13 | “{{param}}”不得早于 {{from}} |
| DateTo | DateTo:2017-04-13 | “{{param}}”不得晚于 {{to}} |
| DateFromTo | DateFromTo:2017-04-13,2017-04-13 | “{{param}}”必须在 {{from}} ~ {{to}} 之间 |
| DateTime | DateTime | “{{param}}”必须符合日期时间格式YYYY-MM-DD HH:mm:ss |
| DateTimeFrom | DateTimeFrom:2017-04-13 12:00:00 | “{{param}}”不得早于 {{from}} |
| DateTimeTo | DateTimeTo:2017-04-13 12:00:00 | “{{param}}”必须早于 {{to}} |
| DateTimeFromTo | DateTimeFromTo:2017-04-13 12:00:00,2017-04-13 12:00:00 | “{{param}}”必须在 {{from}} ~ {{to}} 之间 |

### 3.9 条件判断型

在一条验证规则中，条件验证器必须在其它验证器前面，多个条件验证器可以串联。

注意，条件判断中的“条件”一般是检测另外一个参数的值，而当前参数的值是由串联在条件判断验证器后面的其它验证器来验证。

| 条件判断型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| If|  If:selected |  值是否等于 1, true, '1', 'true', 'yes', 'y'(字符串忽略大小写) |
| IfNot|  IfNot:selected |  值是否等于 0, false, '0', 'false', 'no', 'n'(字符串忽略大小写) |
| IfTrue|  IfTrue:selected |  值是否等于 true 或 'true'(忽略大小写) |
| IfFalse|  IfFalse:selected |  值是否等于 false 或 'false'(忽略大小写) |
| IfExist|  IfExist:var |  如果参数 var 存在 |
| IfNotExist|  IfNotExist:var |  如果参数 var 不存在 |
| IfIntEq|  IfIntEq:var,1 |  if (type === 1) |
| IfIntNe|  IfIntNe:var,2 |  if (state !== 2). 特别要注意的是如果条件参数var的数据类型不匹配, 那么If条件是成立的; 而其它几个IfIntXx当条件参数var的数据类型不匹配时, If条件不成立 |
| IfIntGt|  IfIntGt:var,0 |  if (var > 0) |
| IfIntLt|  IfIntLt:var,1 |  if (var < 0) |
| IfIntGe|  IfIntGe:var,6 |  if (var >= 6) |
| IfIntLe|  IfIntLe:var,8 |  if (var <= 8) |
| IfIntIn|  IfIntIn:var,2,3,5,7 |  if (in_array(var, \[2,3,5,7])) |
| IfIntNotIn|  IfIntNotIn:var,2,3,5,7 |  if (!in_array(var, \[2,3,5,7])) |
| IfStrEq|  IfStrEq:var,waiting |  if (type === 'waiting') |
| IfStrNe|  IfStrNe:var,editing |  if (state !== 'editing'). 特别要注意的是如果条件参数var的数据类型不匹配, 那么If条件是成立的; 而其它几个IfStrXx当条件参数var的数据类型不匹配时, If条件不成立 |
| IfStrGt|  IfStrGt:var,a |  if (var > 'a') |
| IfStrLt|  IfStrLt:var,z |  if (var < 'z') |
| IfStrGe|  IfStrGe:var,A |  if (var >= '0') |
| IfStrLe|  IfStrLe:var,Z |  if (var <= '9') |
| IfStrIn|  IfStrIn:var,normal,warning,error |  if (in_array(var, \['normal', 'warning', 'error'], true)) |
| IfStrNotIn|  IfStrNotIn:var,warning,error |  if (!in_array(var, \['warning', 'error'], true)) |

### 3.10 其它验证器

| 其它验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Required | Required | 待验证的参数是必需的。如果验证器串联，除了条件型验证器外，必须为第一个验证器 |
| Alias | Alias: 参数名称 | 自定义错误提示文本中的参数名称（必须是最后一个验证器） |
| \>>>: | \>>>:这是自定义错误提示文本 | 自定义错误提示文本（与Alias验证器二选一，必须是最后一个验证器） |
| 自定义PHP函数 | function() {} | 暂不提供该机制，因为如果遇到本工具不支持的复杂参数验证，你可以直接写PHP代码来验证，不需要再经由本工具来验证（否则就是脱裤子放屁，多此一举） |

# todo list
* 国际化解决方案
* 性能优化