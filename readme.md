# WebGeeker-Validation: 参数验证神器
一个强大的参数验证工具，能够覆盖80%的API请求参数合法性验证需求，理论上可以验证无限嵌套的数据结构中的参数。

支持多种数据类型的验证：整型、浮点型、bool型、字符串、数组、对象、文件、日期时间，还支持带条件判断的验证。

- 目录
  * [1 安装](#1-%E5%AE%89%E8%A3%85)
  * [2 快速上手](#2-%E5%BF%AB%E9%80%9F%E4%B8%8A%E6%89%8B)
    + [2.1 一个完整的示例（不使用任何框架）](#21-%E4%B8%80%E4%B8%AA%E5%AE%8C%E6%95%B4%E7%9A%84%E7%A4%BA%E4%BE%8B%E4%B8%8D%E4%BD%BF%E7%94%A8%E4%BB%BB%E4%BD%95%E6%A1%86%E6%9E%B6)
    + [2.2 验证不通过的错误处理](#22-%E9%AA%8C%E8%AF%81%E4%B8%8D%E9%80%9A%E8%BF%87%E7%9A%84%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86)
    + [2.2 在第三方框架中的用法](#22-%E5%9C%A8%E7%AC%AC%E4%B8%89%E6%96%B9%E6%A1%86%E6%9E%B6%E4%B8%AD%E7%9A%84%E7%94%A8%E6%B3%95)
  * [3 详细使用方法](#3-%E8%AF%A6%E7%BB%86%E4%BD%BF%E7%94%A8%E6%96%B9%E6%B3%95)
    + [3.1 验证整型参数](#31-%E9%AA%8C%E8%AF%81%E6%95%B4%E5%9E%8B%E5%8F%82%E6%95%B0)
    + [3.2 验证浮点型参数](#32-%E9%AA%8C%E8%AF%81%E6%B5%AE%E7%82%B9%E5%9E%8B%E5%8F%82%E6%95%B0)
    + [3.3 验证bool型参数](#33-%E9%AA%8C%E8%AF%81bool%E5%9E%8B%E5%8F%82%E6%95%B0)
    + [3.4 验证字符串型参数](#34-%E9%AA%8C%E8%AF%81%E5%AD%97%E7%AC%A6%E4%B8%B2%E5%9E%8B%E5%8F%82%E6%95%B0)
    + [3.5 验证数组型、对象型、文件型、日期时间型参数](#35-%E9%AA%8C%E8%AF%81%E6%95%B0%E7%BB%84%E5%9E%8B%E5%AF%B9%E8%B1%A1%E5%9E%8B%E6%96%87%E4%BB%B6%E5%9E%8B%E6%97%A5%E6%9C%9F%E6%97%B6%E9%97%B4%E5%9E%8B%E5%8F%82%E6%95%B0)
    + [3.6 验证器串联（与）](#36-%E9%AA%8C%E8%AF%81%E5%99%A8%E4%B8%B2%E8%81%94%E4%B8%8E)
    + [3.7 Required 验证器](#37-required-%E9%AA%8C%E8%AF%81%E5%99%A8)
    + [3.8 忽略所有 Required 验证器](#38-%E5%BF%BD%E7%95%A5%E6%89%80%E6%9C%89-required-%E9%AA%8C%E8%AF%81%E5%99%A8)
    + [3.9 嵌套参数的验证](#39-%E5%B5%8C%E5%A5%97%E5%8F%82%E6%95%B0%E7%9A%84%E9%AA%8C%E8%AF%81)
    + [3.10 条件判断型验证器](#310-%E6%9D%A1%E4%BB%B6%E5%88%A4%E6%96%AD%E5%9E%8B%E9%AA%8C%E8%AF%81%E5%99%A8)
    + [3.11 验证规则并联（或）](#311-%E9%AA%8C%E8%AF%81%E8%A7%84%E5%88%99%E5%B9%B6%E8%81%94%E6%88%96)
    + [3.12 关于特殊值`null`, `""`，`0`，`false`的问题](#312-%E5%85%B3%E4%BA%8E%E7%89%B9%E6%AE%8A%E5%80%BCnull-0false%E7%9A%84%E9%97%AE%E9%A2%98)
    + [3.13 关于基本数据类型与字符串的关系](#313-%E5%85%B3%E4%BA%8E%E5%9F%BA%E6%9C%AC%E6%95%B0%E6%8D%AE%E7%B1%BB%E5%9E%8B%E4%B8%8E%E5%AD%97%E7%AC%A6%E4%B8%B2%E7%9A%84%E5%85%B3%E7%B3%BB)
    + [3.14 自定义错误信息描述文本](#314-%E8%87%AA%E5%AE%9A%E4%B9%89%E9%94%99%E8%AF%AF%E4%BF%A1%E6%81%AF%E6%8F%8F%E8%BF%B0%E6%96%87%E6%9C%AC)
  * [A 附录 - 验证器列表](#a-%E9%99%84%E5%BD%95---%E9%AA%8C%E8%AF%81%E5%99%A8%E5%88%97%E8%A1%A8)
    + [A.1 整型](#a1-%E6%95%B4%E5%9E%8B)
    + [A.2 浮点型](#a2-%E6%B5%AE%E7%82%B9%E5%9E%8B)
    + [A.3 bool型](#a3-bool%E5%9E%8B)
    + [A.4 字符串型](#a4-%E5%AD%97%E7%AC%A6%E4%B8%B2%E5%9E%8B)
    + [A.5 数组型](#a5-%E6%95%B0%E7%BB%84%E5%9E%8B)
    + [A.6 对象型](#a6-%E5%AF%B9%E8%B1%A1%E5%9E%8B)
    + [A.7 文件型](#a7-%E6%96%87%E4%BB%B6%E5%9E%8B)
    + [A.8 日期和时间型](#a8-%E6%97%A5%E6%9C%9F%E5%92%8C%E6%97%B6%E9%97%B4%E5%9E%8B)
    + [A.9 条件判断型](#a9-%E6%9D%A1%E4%BB%B6%E5%88%A4%E6%96%AD%E5%9E%8B)
    + [A.10 其它验证器](#a10-%E5%85%B6%E5%AE%83%E9%AA%8C%E8%AF%81%E5%99%A8)

#### 为什么要写这样一个工具

我在使用Laravel框架的时候，Laravel提供了一个参数验证工具，不过用起来不怎么顺畅：
* 每一个验证都写一个验证类（继承XXX），这样太麻烦，而且系统中会多出许多许多的类；如果这些类在多处被复用，或者为了“更加”复用（减少重复代码），再在这些类之间搞出很多的继承关系，那么这些类的维护本身就是一个大问题；
* 验证器有“一词多义”的问题。比如它有一个`size`验证器，它同时支持验证字符串、整型、文件等多种类型的参数，针对不同数据类型`size`的含义不一样。这就好比你去背英语单词，有那么一些英语单词，它有很多很多意思，不同的语境下有不同的含义。比如"present"这个单词，它既有“呈现”、“出席”的意思，也有“礼物”的意思。这种一词多义的单词最让人头疼了，搞不清它到底什么意思，而且记不住啊。

为了解决这些问题，所以才写了这么一个工具。

####特点
1. 简洁，验证逻辑一目了然（参考后面的例子）
1. 轻量，不需要定义和维护各种验证classes
1. 验证器语义明确，没有“一词多义”的问题
1. 支持正则表达式验证
1. 支持条件验证
1. 理论上能够支持验证无限嵌套的参数
1. 易学易记。比如整型验证器都是以"Int"开头，浮点型验证器都是以"Float"开头，等等。唯一不符合这一规则的是字符串型验证器，它们一部分以"Str"开头的，但也有一部分不以"Str"开头，比如`Regexp`, `Ip`, `Email`, `Url`等。
1. 不绑定任何一个框架，无任何依赖。你可以在任何一个框架中使用这个工具，就算你不使用框架，也可以使用本工具。

#### 示例

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

## 1 安装

通过Composer安装
```
composer require webgeeker/validation:^0.2
```

## 2 快速上手

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
*注意*：验证不通过会抛出异常，该异常中包含有错误描述信息

### 2.2 验证不通过的错误处理

如果验证不通过，`Validation::validate(...)`方法会抛出异常，建议在框架层面统一捕获这些异常，提取错误描述信息并返回给客户端。

### 2.2 在第三方框架中的用法

第三方框架一般会提供Request对象，可以取到GET, POST参数（以Laravel为例）

```php
//$params = $request->query(); // 获取GET参数
$params = $request->request->all(); // 获取POST参数

// 验证（如果验证不通过，会抛出异常）
Validation::validate($params, [
    // 此处省略验证规则
]);
```

## 3 详细使用方法

### 3.1 验证整型参数

整型验证器全部以"Int"开头，用于验证整型数值（如`123`）或整型字符串（如`"123"`）。其它数据类型均不匹配。

```php
"size" => "IntGeLe:1,100"
```
这条验证要求参数"size"是整数，并且大于等于1，小于等于100。

完整的整型验证器的列表参考附录 A.1 。

### 3.2 验证浮点型参数

浮点型验证器全部以"Float"开头，用于验证浮点型数值（如`1.0`）、浮点型字符串（如`"1.0"`）、整型数值（如`123`）或整型字符串（如`"123"`）。其它数据类型均不匹配。

```php
"height" => "FloatGeLe:0.0,100.0"
```
这条验证要求参数"height"是浮点数，并且大于等于0，小于等于100.0。

完整的浮点型验证器的列表参考附录 A.2 。

### 3.3 验证bool型参数

bool型验证器只有两个：
* Bool: 合法的取值为: `true`, `false`, `"true"`, `"false"`（字符串忽略大小写）。
* BoolSmart: 合法的取值为: `true`, `false`, `"true"`, `"false"`, `1`, `0`, `"1"`, `"0"`, `"yes"`, `"no"`, `"y"`, `"n"`（字符串忽略大小写）

例
```php
"accept" => "BoolSmart"
```

完整的bool型验证器的列表参考附录 A.3 。

### 3.4 验证字符串型参数

字符串型验证器不全以"Str"开头。只接收字符串型数据，其它数据类型均不匹配。

例1：
```php
"name" => "StrLenGeLe:2,20"
```
这条验证要求参数"name"是字符串，长度在2-20之间（字符串长度是用`mb_strlen()`来计算的）。

例2：
```php
"comment" => "ByteLenLe:1048576"
```
这条验证要求参数"comment"是字符串，字节长度不超过1048576（字节长度是用`strlen()`来计算的）。

例3：
```php
"email" => "Email"
```
这条验证要求参数"email"是必须是合法的电子邮件地址。

例4（正则表达式验证）：
```php
"phone" => "Regexp:/^1(3[0-9]|4[579]|5[0-35-9]|7[0135678]|8[0-9]|66|9[89])\d{8}$/"
```
这条验证要求参数"phone"是合法的手机号。

完整的字符串型验证器的列表参考附录 A.4 。

### 3.5 验证数组型、对象型、文件型、日期时间型参数

参考附录A.5-A.8

### 3.6 验证器串联（与）

一条规则中可以有多个验证器前后串联，它们之间是“AND”的关系，如：
```php
"file" => "FileMaxSize:10m|FileImage"
```
这个验证要求参数"file"是一个图像文件，并且文件大小不超过10m


### 3.7 Required 验证器

* Required验证器要求参数必须存在，且其值不能为`null`（这个是PHP的`null`值，而不是字符串"null"）（参数值为`null`等价于参数不存在）。
* 如果多个验证器串联，Required验证器必须在其它验证器前面。
* 如果还有条件验证器，Required必须串联在条件验证器后面。
* 如果验证规则中没有 Required，当参数存在时才进行验证，验证不通过会抛异常；如果参数不存在，那么就不验证（相当于验证通过）

例：
```php
"size" => "Required|StrIn:small,middle,large"
```
该验证要求参数"size"必须是字符串的"small", "middle"或者"large"。

### 3.8 忽略所有 Required 验证器

比如当创建一个用户时，要求姓名、性别、年龄全部都要提供；但是当更新用户信息时，不需要提供全部信息，提供哪个信息就更新哪个信息。

```php
$validations = [
    "name" => "Required|StrLenGeLe:2,20",
    "sex" => "Required|IntIn:0,1",
    "age" => "Required|IntGeLe:1,200",
];

$userInfo = [
    "name" => "tom",
    "sex" => "0",
    "age" => "10",
];
Validation::validate($userInfo, $validations); // 创建用户时的验证

unset($userInfo["age"]); // 删除age字段
Validation::validate($userInfo, $validations, true); // 更新用户信息时的验证
```
注意上面代码的最后一行：`validate()`函数的第三个参数为true表示忽略所有的 Required 验证器。

这样我们就只需要写一份验证规则，就可以同时用于创建用户和更新用户信息这两个接口。

### 3.9 嵌套参数的验证

下面这个例子展示了包含数组和对象的嵌套的参数的验证：
```php
$params = [
    "comments" => [
        [
            "title" => "title 1",
            "content" => "content 1",
        ],
        [
            "title" => "title 1",
            "content" => "content 1",
        ],
        [
            "title" => "title 1",
            "content" => "content 1",
        ],
    ]
];

$validations = [
    "comments[*].title" => "Required|StrLenGeLe:2,50",
    "comments[*].content" => "Required|StrLenGeLe:2,500",
];

Validation::validate($params, $validations);
```

### 3.10 条件判断型验证器

条件判断型验证器都以"If"开头。

比如你想招聘一批模特，男的要求180以上，女的要求170以上，验证可以这样写：
```php
$validations = [
    "sex" => "StrIn:male,female",
    "height" => [
        "IfStrEq:sex,male|IntGe:180",
        "IfStrEq:sex,female|IntGe:170",
    ],
];
```
参数"sex"的值不同，参数"height"的验证规则也不一样。

完整的条件判断型验证器的列表参考附录 A.9 。

### 3.11 验证规则并联（或）

多条验证规则可以并联，它们之间是“或”的关系，如
```php
"type" => [
    "StrIn:small,middle,large",
    "IntIn:1,2,3",
]
```
上面这条验证要求参数"type"既可以是字符串"small", "middle"或"large"，也可以整型的1, 2或3

验证规则并联不是简单的“或”的关系，具体验证流程如下：
1. 按顺序验证这些规则，如果有一条验证规则通过, 则该参数验证通过。
2. 如果全部验证规则都被忽略（If验证器条件不满足，或者没有Required验证器并且该参数不存在，或者有0条验证规则），也算参数验证通过。
3. 上面两条都不满足, 则该参数验证失败。

这些规则如果要完全理清并不是一件容易的事，所以不建议使用验证规则并联，也尽量不要设计需要这种验证方式的参数。

### 3.12 关于特殊值`null`, `""`，`0`，`false`的问题

这些特殊的值是不等价的，它们是不同的数据类型（需要用不同的验证器去验证）：
* `""`是字符串。
* `0`是整型。
* `false`是bool型。
* `null`是PHP的空。在本工具中它有特殊的含义。

如果某个参数的值为`null`，则本工具会视为该参数不存在。

比如下面两个array对于本工具来说是等价的.
```php
$params = [
    "name" => "hello",
];
```
与
```php
$params = [
    "name" => "hello",
    "comment" => null,
];
```
是等价的。

### 3.13 关于基本数据类型与字符串的关系

对于以下url地址
```
http://abc.com/index.php?p1=&&p2=hello&&p3=123
```
我们将得到的参数数组：
```php
$params = [
    "p1" => "",
    "p2" => "hello",
    "p3" => "123",
];
```
*注意*：
* 参数"p1"的值为空字符串`""`，而不是`null`。
* 参数"p3"的值为字符串`"123"`，而不是整型`123`。
* GET方式的HTTP请求是传递不了`null`值的。

本工具的所有验证器都是**强类型**的，"Int*"验证的是整型，"Float*"验证的是浮点型，"Str*"验证的是字符串型，数据类型不匹配，验证是通不过的。但是字符串类型是个例外。

因为常规的HTTP请求，所有的基本数据类型最终都会转换成字符串，所以：
* 整型`123`和字符串`"123"`均可以通过验证器"Int"的验证；
* 浮点型`123.0`和字符串`"123.0"`均可以通过验证器"Float"的验证；
* bool型`true`和字符串`"true"`均可以通过验证器"Bool"的验证；
* 但是`null`值和字符串`"null"`永远不等价，字符串`"null"`就只是普通的字符串。

### 3.14 自定义错误信息描述文本

如果参数验证不通过，`Validation::validate()`方法会抛出异常，这个异常会包含验证不通过的详细描述的文本。

但是这个描述文本对用户来说可能不那么友好，我们可以通过验证器`Alias`或者`>>>:`来自定义错误描述文本。看下面的例子：

```php
$params = [
    "title" => "a",
];

Validation::validate($params, [
    "title" => "Required|StrLenGeLe:2,50",
]); // 抛出异常的错误描述为：“title”长度必须在 2 - 50 之间

Validation::validate($params, [
    "title" => "Required|StrLenGeLe:2,50|Alias:标题",
]); // 抛出异常的错误描述为：“标题”长度必须在 2 - 50 之间

Validation::validate($params, [
    "title" => "Required|StrLenGeLe:2,50|>>>:标题长度应在2~50之间",
]); // 抛出异常的错误描述为：标题长度应在2~50之间
```
参考附录A.10获取更详细的信息

## A 附录 - 验证器列表

### A.1 整型

整型验证器全部以"Int"开头。

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

### A.2 浮点型

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

### A.3 bool型

| bool型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Bool | Bool | 合法的取值为: `true`, `false`, `"true"`, `"false"`（忽略大小写） |
| BoolSmart | BoolSmart | 合法的取值为: `true`, `false`, `"true"`, `"false"`, `1`, `0`, `"1"`, `"0"`, `"yes"`, `"no"`, `"y"`, `"n"`（忽略大小写） |

### A.4 字符串型

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

### A.5 数组型

| 数组型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Arr | Arr | “{{param}}”必须是数组 |
| ArrLen | ArrLen:5 | “{{param}}”数组长度必须等于 {{length}} |
| ArrLenGe | ArrLenGe:1 | “{{param}}”数组长度必须大于等于 {{min}} |
| ArrLenLe | ArrLenLe:9 | “{{param}}”数组长度必须小于等于 {{max}} |
| ArrLenGeLe | ArrLenGeLe:1,9 | “{{param}}”长数组度必须在 {{min}} ~ {{max}} 之间 |

### A.6 对象型

| 对象型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Obj | Obj | “{{param}}”必须是对象 |

### A.7 文件型

| 文件型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| File | File | “{{param}}”必须是文件 |
| FileMaxSize | FileMaxSize:10mb | “{{param}}”必须是文件, 且文件大小不超过{{size}} |
| FileMinSize | FileMinSize:100kb | “{{param}}”必须是文件, 且文件大小不小于{{size}} |
| FileImage | FileImage | “{{param}}”必须是图片 |
| FileVideo | FileVideo | “{{param}}”必须是视频文件 |
| FileAudio | FileAudio | “{{param}}”必须是音频文件 |
| FileMimes | FileMimes:mpeg,jpeg,png | “{{param}}”必须是这些MIME类型的文件:{{mimes}} |

### A.8 日期和时间型

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

### A.9 条件判断型

在一条验证规则中，条件验证器必须在其它验证器前面，多个条件验证器可以串联。

注意，条件判断中的“条件”一般是检测**另外一个参数**的值，而当前参数的值是由串联在条件判断验证器后面的其它验证器来验证。

| 条件判断型验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| If|  If:selected |  如果参数"selected"值等于 1, true, '1', 'true', 'yes'或 'y'(字符串忽略大小写) |
| IfNot|  IfNot:selected |  如果参数"selected"值等于 0, false, '0', 'false', 'no'或'n'(字符串忽略大小写) |
| IfTrue|  IfTrue:selected |  如果参数"selected"值等于 true 或 'true'(忽略大小写) |
| IfFalse|  IfFalse:selected |  如果参数"selected"值等于 false 或 'false'(忽略大小写) |
| IfExist|  IfExist:var |  如果参数"var"存在 |
| IfNotExist|  IfNotExist:var |  如果参数"var"不存在 |
| IfIntEq|  IfIntEq:var,1 |  if (var === 1) |
| IfIntNe|  IfIntNe:var,2 |  if (var !== 2). 特别要注意的是如果条件参数var的数据类型不匹配, 那么If条件是成立的; 而其它几个IfIntXx当条件参数var的数据类型不匹配时, If条件不成立 |
| IfIntGt|  IfIntGt:var,0 |  if (var > 0) |
| IfIntLt|  IfIntLt:var,1 |  if (var < 0) |
| IfIntGe|  IfIntGe:var,6 |  if (var >= 6) |
| IfIntLe|  IfIntLe:var,8 |  if (var <= 8) |
| IfIntIn|  IfIntIn:var,2,3,5,7 |  if (in_array(var, \[2,3,5,7])) |
| IfIntNotIn|  IfIntNotIn:var,2,3,5,7 |  if (!in_array(var, \[2,3,5,7])) |
| IfStrEq|  IfStrEq:var,waiting |  if (var === 'waiting') |
| IfStrNe|  IfStrNe:var,editing |  if (var !== 'editing'). 特别要注意的是如果条件参数var的数据类型不匹配, 那么If条件是成立的; 而其它几个IfStrXx当条件参数var的数据类型不匹配时, If条件不成立 |
| IfStrGt|  IfStrGt:var,a |  if (var > 'a') |
| IfStrLt|  IfStrLt:var,z |  if (var < 'z') |
| IfStrGe|  IfStrGe:var,A |  if (var >= '0') |
| IfStrLe|  IfStrLe:var,Z |  if (var <= '9') |
| IfStrIn|  IfStrIn:var,normal,warning,error |  if (in_array(var, \['normal', 'warning', 'error'], true)) |
| IfStrNotIn|  IfStrNotIn:var,warning,error |  if (!in_array(var, \['warning', 'error'], true)) |

### A.10 其它验证器

| 其它验证器 | 示例 | 说明 |
| :------| :------ | :------ |
| Required | Required | 待验证的参数是必需的。如果验证器串联，除了条件型验证器外，必须为第一个验证器 |
| Alias | Alias: 参数名称 | 自定义错误提示文本中的参数名称（必须是最后一个验证器） |
| \>>>: | \>>>:这是自定义错误提示文本 | 自定义错误提示文本（与Alias验证器二选一，必须是最后一个验证器） |
| 自定义PHP函数 | function() {} | 暂不提供该机制，因为如果遇到本工具不支持的复杂参数验证，你可以直接写PHP代码来验证，不需要再经由本工具来验证（否则就是脱裤子放屁，多此一举） |

# todo list
* 国际化解决方案
* 性能优化