<?php
/*
 * Project: simpleim-php
 * File: Validation.php
 * CreateTime: 16/11/6 17:22
 * Author: photondragon
 * Email: photondragon@163.com
 */
/**
 * @file Validation.php
 * @brief brief description
 *
 * elaborate description
 */

namespace WebGeeker\Validation;

/**
 * @class Validation
 * @package WebGeeker\Rest
 * @brief brief description
 *
 * elaborate description
 */
class Validation
{
    //region integer

    public static function validateInt($value, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false)
                return $value;
        } elseif ($type === 'integer') {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Int'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateIntEq($value, $equalVal, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val == $equalVal)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value == $equalVal)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntEq'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{value}}', $equalVal, $error);
        throw new \Exception($error);
    }

    public static function validateIntGt($value, $min, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val > $min)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value > $min)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateIntGe($value, $min, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val >= $min)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value >= $min)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateIntLt($value, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val < $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateIntLe($value, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val <= $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateIntGtLt($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val > $min && $val < $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value > $min && $value < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGtLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateIntGeLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val >= $min && $val <= $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value >= $min && $value <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGeLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateIntGtLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val > $min && $val <= $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value > $min && $value <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGtLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateIntGeLt($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) {
                $val = intval($value);
                if ($val >= $min && $val < $max)
                    return $value;
            }
        } elseif ($type === 'integer') {
            if ($value >= $min && $value < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntGeLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    /**
     * 验证IntIn: “{{param}}”只能取这些值: {{valueList}}
     * IntIn与in的区别:
     * 0123 -> IntIn:123 通过; 0123 -> In:123 不通过
     * @param $value string|int 参数值
     * @param $valueList string[] 可取值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return string
     * @throws \Exception
     */
    public static function validateIntIn($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(IntIn:)格式错误, 必须提供可取值的列表");

        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) // 是数字并且没有小数点
            {
                $intValue = intval($value);
                if (in_array($intValue, $valueList, true))
                    return $value;
            }
        } else if ($type === 'integer') {
            if (in_array($value, $valueList, true))
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntIn'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    /**
     * 验证intNotIn: “{{param}}”不能取这些值: {{valueList}}
     * @param $value mixed 参数值
     * @param $valueList array 不可取的值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateIntNotIn($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(intNotIn:)格式错误, 必须提供可取值的列表");

        $type = gettype($value);
        if ($type === 'string') {
            if (is_numeric($value) && strpos($value, '.') === false) // 是数字并且没有小数点
            {
                $intValue = intval($value);
                if (in_array($intValue, $valueList, true) === false)
                    return $value;
            }
        } else if ($type === 'integer') {
            if (in_array($value, $valueList, true) === false)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['IntNotIn'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    //endregion

    //region float

    public static function validateFloat($value, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value))
            return $value;

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Float'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGt($value, $min, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f > $min)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGe($value, $min, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f >= $min)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateFloatLt($value, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateFloatLe($value, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGtLt($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f > $min && $f < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGtLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGeLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f >= $min && $f <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGeLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGtLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f > $min && $f <= $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGtLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateFloatGeLt($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_numeric($value)) {
            $f = floatval($value);
            if ($f >= $min && $f < $max)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['FloatGeLt'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    //endregion

    //region bool

    public static function validateBool($value, $reason = null, $alias = 'Parameter')
    {
        if (is_bool($value)) {
            return $value;
        } else if (is_string($value)) {
            $valuelc = strtolower($value);
            if($valuelc === 'true' || $valuelc === 'false')
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Bool'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateBoolSmart($value, $reason = null, $alias = 'Parameter')
    {
        if (is_bool($value)) {
            return $value;
        } else if (is_string($value)) {
            if(in_array(strtolower($value), ['true', 'false', 'yes', 'no', '1', '0', 'y', 'n'], true))
                return $value;
        } else if(is_numeric($value)) {
            if($value === 1 || $value === 0)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['BoolSmart'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    //endregion

    //region string

    public static function validateString($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Len'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateLen($value, $length, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (mb_strlen($value) == $length) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Len'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{length}}', $length, $error);
        throw new \Exception($error);
    }

    public static function validateLenGe($value, $min, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (mb_strlen($value) >= $min) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['LenGe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateLenLe($value, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (mb_strlen($value) <= $max) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['LenLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateLenGeLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if ($min > $max)
            throw new \Exception("“${alias}”参数的验证模版LenGeLe格式错误, min不应该大于max");

        if (is_string($value)) {
            $len = mb_strlen($value);
            if ($len >= $min && $len <= $max) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['LenGeLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateByteLen($value, $length, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (strlen($value) == $length) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ByteLen'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{length}}', $length, $error);
        throw new \Exception($error);
    }

    public static function validateByteLenGe($value, $min, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (strlen($value) >= $min) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ByteLenGe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateByteLenLe($value, $max, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (strlen($value) <= $max) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ByteLenLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateByteLenGeLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if ($min > $max)
            throw new \Exception("“${alias}”参数的验证模版LenGeLe格式错误, min不应该大于max");

        if (is_string($value)) {
            $len = strlen($value);
            if ($len >= $min && $len <= $max) {
                return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ByteLenGeLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能包含字母
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateLetters($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[a-zA-Z]+$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Letters'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能包含字母
     * 同Letters
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateAlphabet($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[a-zA-Z]+$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Alphabet'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能是纯数字
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateNumbers($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[0-9]+$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Numbers'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能是纯数字
     * 同Numbers
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateDigits($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[0-9]+$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Digits'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能包含字母和数字
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateLettersNumbers($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['LettersNumbers'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”必须是数值
     * 一般用于大数处理（超过double表示范围的数,一般会用字符串来表示）
     * 如果是正常范围内的数, 可以使用'Int'或'Float'来检测
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateNumeric($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^\-?[0-9.]+$/', $value) === 1) {
                $count = 0; //小数点的个数
                $i = 0;
                while (($i = strpos($value, '.', $i)) !== false) {
                    $count++;
                    $i += 1;
                }
                if ($count === 0)
                    return $value;
                else if ($count === 1) {
                    if ($value !== '.' && $value !== '-.')
                        return $value;
                }
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Numeric'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能包含字母、数字和下划线，并且以字母或下划线开头
     * @param $value mixed 参数值
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateVarName($value, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value)) {
            if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $value) === 1)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['VarName'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”必须等于 {{equalsValue}}
     * @param $value string 参数值
     * @param $equalsValue string 可取值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateEquals($value, $equalsValue, $reason = null, $alias = 'Parameter')
    {
        if (is_string($value) && $value === $equalsValue)
            return $value;

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Equals'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{value}}', $equalsValue, $error);
        throw new \Exception($error);
    }

    public static function validateEmail($value, $reason = null, $alias = 'Parameter')
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Email'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateUrl($value, $reason = null, $alias = 'Parameter')
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Url'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateIp($value, $reason = null, $alias = 'Parameter')
    {
        if (filter_var($value, FILTER_VALIDATE_IP)) {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Ip'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateMac($value, $reason = null, $alias = 'Parameter')
    {
        if (filter_var($value, FILTER_VALIDATE_MAC)) {
            return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Mac'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能取这些值: {{valueList}}
     * @param $value string 参数值
     * @param $valueList string[] 可取值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return string
     * @throws \Exception
     */
    public static function validateIn($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(In:)格式错误, 必须提供可取值的列表");

        if (in_array($value, $valueList, true))
            return $value;

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['In'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”不能取这些值: {{valueList}}
     * @param $value mixed 参数值
     * @param $valueList array 不可取的值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateNotIn($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(NotIn:)格式错误, 必须提供不可取的值的列表");

        if (in_array($value, $valueList, true) === false)
            return $value;

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['NotIn'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”只能取这些值: {{valueList}}（忽略大小写）
     * @param $value mixed 参数值
     * @param $valueList array 可取值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateInNoCase($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(InNoCase:)格式错误, 必须提供可取值的列表");

        $lowerValue = strtolower($value);
        foreach ($valueList as $v) {
            if (is_string($v) && strtolower($v) === $lowerValue)
                continue;
            goto VeriFailed;
        }
        return $value;

        VeriFailed:

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['InNoCase'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    /**
     * 验证: “{{param}}”不能取这些值: {{valueList}}（忽略大小写）
     * @param $value mixed 参数值
     * @param $valueList array 不可取的值的列表
     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateNotInNoCase($value, $valueList, $reason = null, $alias = 'Parameter')
    {
        if (is_array($valueList) === false || count($valueList) === 0)
            throw new \Exception("“${alias}”参数的验证模版(NotInNoCase:)格式错误, 必须提供不可取的值的列表");

        $lowerValue = strtolower($value);
        foreach ($valueList as $v) {
            if (is_string($v) && strtolower($v) === $lowerValue)
                continue;
            goto VeriFailed;
        }
        return $value;

        VeriFailed:

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['NotInNoCase'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{valueList}}', implode(', ', $valueList), $error);
        throw new \Exception($error);
    }

    /**
     * Perl正则表达式验证
     * @param $value string 参数值
     * @param $regexp string Perl正则表达式. 正则表达式内的特殊字符需要转义（包括/）. 首尾无需加/
     * @param $reason null|string 原因（当不匹配时用于错误提示）. 如果为null, 当不匹配时会提示 “${alias}”不匹配正则表达式$regexp
     * @param $alias string 参数别名, 用于错误提示
     * @return mixed
     * @throws \Exception
     */
    public static function validateRegexp($value, $regexp, $reason = null, $alias = 'Parameter')
    {
        if (is_string($regexp) === false || $regexp === '')
            throw new \Exception("“${alias}”参数的验证模版(Regexp:)格式错误, 没有提供正则表达式");

        $result = @preg_match($regexp, $value);
        if ($result === 1)
            return $value;
        else if ($result === false)
            throw new \Exception("“${alias}”参数的正则表达式验证失败, 请检查正则表达式是否合法");

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Regexp'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{regexp}}', $regexp, $error);
        throw new \Exception($error);
    }

    //endregion

    //region array

    public static function validateArray($value, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value)) {
            $is = true;
            foreach ($value as $key => $val) {
                if(!is_integer($key)) {
                    $is = false;
                    break;
                }
            }
            if($is)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Array'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    public static function validateArrayLen($value, $length, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value) && count($value) == $length) {
            $is = true;
            foreach ($value as $key => $val) {
                if(!is_integer($key)) {
                    $is = false;
                    break;
                }
            }
            if($is)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ArrayLen'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{length}}', $length, $error);
        throw new \Exception($error);
    }

    public static function validateArrayLenGe($value, $min, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value) && count($value) >= $min) {
            $is = true;
            foreach ($value as $key => $val) {
                if(!is_integer($key)) {
                    $is = false;
                    break;
                }
            }
            if($is)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ArrayLenGe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        throw new \Exception($error);
    }

    public static function validateArrayLenLe($value, $max, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value) && count($value) <= $max) {
            $is = true;
            foreach ($value as $key => $val) {
                if(!is_integer($key)) {
                    $is = false;
                    break;
                }
            }
            if($is)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ArrayLenLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    public static function validateArrayLenGeLe($value, $min, $max, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value)) {
            $c = count($value);
            if($c >= $min && $c <= $max) {
                $is = true;
                foreach ($value as $key => $val) {
                    if (!is_integer($key)) {
                        $is = false;
                        break;
                    }
                }
                if ($is)
                    return $value;
            }
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['ArrayLenGeLe'];
        $error = str_replace('{{param}}', $alias, $error);
        $error = str_replace('{{min}}', $min, $error);
        $error = str_replace('{{max}}', $max, $error);
        throw new \Exception($error);
    }

    //endregion

    //region others

//    /**
//     * 检测参数是否存在并且不为null
//     *
//     * @param $value mixed
//     * @param $reason string|null 验证失败的错误提示字符串. 如果为null, 则自动生成
//     * @param string $alias
//     * @return mixed
//     * @throws \Exception
//     */
//    public static function validateRequired($value, $reason = null, $alias = 'Parameter')
//    {
//        if($value !== null) //参数不存在或参数值为null时, $value的值都是null
//            return $value;
//
//        if($reason !== null)
//            throw new \Exception($reason);
//
//        $error = self::$errorTemplates['Required'];
//        $error = str_replace('{{param}}', $alias, $error);
//        throw new \Exception($error);
//    }

    public static function validateObject($value, $reason = null, $alias = 'Parameter')
    {
        if(is_array($value)) {
            $is = true;
            foreach ($value as $key => $val) {
                if (!is_string($key)) {
                    $is = false;
                    break;
                }
            }
            if ($is)
                return $value;
        }

        if($reason !== null)
            throw new \Exception($reason);

        $error = self::$errorTemplates['Object'];
        $error = str_replace('{{param}}', $alias, $error);
        throw new \Exception($error);
    }

    //endregion

    //region ifs

    protected static function validateIf($value)
    {
        if (is_string($value))
            $value = strtolower($value);
        return in_array($value, [1, true, '1', 'true', 'yes', 'y'], true);
    }

    protected static function validateIfNot($value)
    {
        if (is_string($value))
            $value = strtolower($value);
        return in_array($value, [0, false, '0', 'false', 'no', 'n'], true);
    }

    protected static function validateIfTrue($value)
    {
        if (is_string($value))
            return (strtolower($value) === 'true');
        else
            return ($value === true);
    }

    protected static function validateIfFalse($value)
    {
        if (is_string($value))
            return (strtolower($value) === 'false');
        else
            return ($value === false);
    }

    protected static function validateIfExist($value)
    {
        return ($value !== null);
    }

    protected static function validateIfNotExist($value)
    {
        return ($value === null);
    }

    protected static function validateIfIntEq($value, $compareVal)
    {
        return ($value === $compareVal || $value === "$compareVal");
    }

    protected static function validateIfIntNe($value, $compareVal)
    {
        return !($value === $compareVal || $value === "$compareVal");
    }

    protected static function validateIfIntGt($value, $compareVal)
    {
        if (is_string($value)) {

            if (is_numeric($value) && strpos($value, '.') === false)
                return (intval($value) > $compareVal);
            else
                return false;
        } else if (is_integer($value)) {
            return ($value > $compareVal);
        }
        return false;
    }

    protected static function validateIfIntGe($value, $compareVal)
    {
        if (is_string($value)) {

            if (is_numeric($value) && strpos($value, '.') === false)
                return (intval($value) >= $compareVal);
            else
                return false;
        } else if (is_integer($value)) {
            return ($value >= $compareVal);
        }
        return false;
    }

    protected static function validateIfIntLt($value, $compareVal)
    {
        if (is_string($value)) {

            if (is_numeric($value) && strpos($value, '.') === false)
                return (intval($value) < $compareVal);
            else
                return false;
        } else if (is_integer($value)) {
            return ($value < $compareVal);
        }
        return false;
    }

    protected static function validateIfIntLe($value, $compareVal)
    {
        if (is_string($value)) {

            if (is_numeric($value) && strpos($value, '.') === false)
                return (intval($value) <= $compareVal);
            else
                return false;
        } else if (is_integer($value)) {
            return ($value <= $compareVal);
        }
        return false;
    }

    protected static function validateIfIn($value, $valuesList)
    {
        return in_array($value, $valuesList);
    }

    protected static function validateIfNotIn($value, $valuesList)
    {
        return !in_array($value, $valuesList);
    }

    //endregion

    /**
     * @var array 验证失败时的错误提示信息的模板
     *
     * 输入值一般为字符串
     */
    static protected $errorTemplates = [
        // 整型（不提供length检测,因为负数的符号位会让人混乱, 可以用大于小于比较来做到这一点）
        'Int' => '“{{param}}”必须是整数',
        'IntEq' => '“{{param}}”必须是等于 {{value}} 的整数',
        'IntGt' => '“{{param}}”必须是大于 {{min}} 的整数',
        'IntGe' => '“{{param}}”必须是大于等于 {{min}} 的整数',
        'IntLt' => '“{{param}}”必须是小于 {{max}} 的整数',
        'IntLe' => '“{{param}}”必须是小于等于 {{max}} 的整数',
        'IntGtLt' => '“{{param}}”必须是整数，取值大于 {{min}} 且小于 {{max}} 的整数',
        'IntGeLe' => '“{{param}}”必须是整数，取值大于等于 {{min}} 且小于等于 {{max}} 的整数',
        'IntGtLe' => '“{{param}}”必须是整数，取值大于 {{min}} 且小于等于 {{max}} 的整数',
        'IntGeLt' => '“{{param}}”必须是整数，取值大于等于 {{min}} 且小于 {{max}} 的整数',
        'IntIn' => '“{{param}}”必须是整数，并且只能取这些值: {{valueList}}',
        'IntNotIn' => '“{{param}}”必须是整数，并且不能取这些值: {{valueList}}',

        // 浮点型（内部一律使用double来处理）
        'Float' => '“{{param}}”必须是浮点数',
        'Double' => '“{{param}}”必须是浮点数', // 同float
        'FloatGt' => '“{{param}}”必须是大于 {{min}} 的浮点数',
        'FloatGe' => '“{{param}}”必须是大于等于 {{min}} 的浮点数',
        'FloatLt' => '“{{param}}”必须是小于 {{max}} 的浮点数',
        'FloatLe' => '“{{param}}”必须是小于等于 {{max}} 的浮点数',
        'FloatGtLt' => '“{{param}}”必须是大于 {{min}} 小于 {{max}} 的浮点数',
        'FloatGeLe' => '“{{param}}”必须是大于等于 {{min}} 小于等于 {{max}} 的浮点数',
        'FloatGtLe' => '“{{param}}”必须是大于 {{min}} 小于等于 {{max}} 的浮点数',
        'FloatGeLt' => '“{{param}}”必须是大于等于 {{min}} 小于 {{max}} 的浮点数',

        // bool型
        'Bool' => '“{{param}}”必须是bool型(true or false)', // 忽略大小写
        'BoolSmart' => '“{{param}}”只能取这些值: true, false, yes, no, 1, 0, y, n（忽略大小写）',

        // 字符串
        'String' => '“{{param}}”必须是字符串',
        'Len' => '“{{param}}”长度必须等于 {{length}}', // 字符串长度
        'LenGe' => '“{{param}}”长度必须大于等于 {{min}}',
        'LenLe' => '“{{param}}”长度必须小于等于 {{max}}',
        'LenGeLe' => '“{{param}}”长度必须在 {{min}} - {{max}} 之间', // 字符串长度
        'ByteLen' => '“{{param}}”长度必须等于 {{length}}', // 字符串长度
        'ByteLenGe' => '“{{param}}”长度必须大于等于 {{min}}',
        'ByteLenLe' => '“{{param}}”长度必须小于等于 {{max}}',
        'ByteLenGeLe' => '“{{param}}”长度必须在 {{min}} - {{max}} 之间', // 字符串长度
        'Letters' => '“{{param}}”只能包含字母',
        'Alphabet' => '“{{param}}”只能包含字母', // 同Letters
        'Numbers' => '“{{param}}”只能是纯数字',
        'Digits' => '“{{param}}”只能是纯数字', // 同Numbers
        'LettersNumbers' => '“{{param}}”只能包含字母和数字',
        'Numeric' => '“{{param}}”必须是数值', // 一般用于大数处理（超过double表示范围的数,一般会用字符串来表示）, 如果是正常范围内的数, 可以使用'Int'或'Float'来检测
        'VarName' => '“{{param}}”只能包含字母、数字和下划线，并且以字母或下划线开头',
        'Equals' => '“{{param}}”必须等于 {{value}}',
        'Email' => '“{{param}}”不是合法的email',
        'Url' => '“{{param}}”不是合法的Url地址',
        'Ip' => '“{{param}}”不是合法的IP地址',
        'Mac' => '“{{param}}”不是合法的MAC地址',
        'In' => '“{{param}}”只能取这些值: {{valueList}}',
        'NotIn' => '“{{param}}”不能取这些值: {{valueList}}',
        'InNoCase' => '“{{param}}”只能取这些值: {{valueList}}（忽略大小写）',
        'NotInNoCase' => '“{{param}}”不能取这些值: {{valueList}}（忽略大小写）',
        'Regexp' => '“{{param}}”不匹配正则表达式“{{regexp}}”', // Perl正则表达式匹配

        // 数组. 如何检测数组长度为0
        'Array' => '“{{param}}”必须是数组',
        'ArrayLen' => '“{{param}}”必须是长度为 {{length}} 的数组',
        'ArrayLenGe' => '“{{param}}”必须是长度大于等于 {{min}} 的数组',
        'ArrayLenLe' => '“{{param}}”必须是长度小于等于 {{max}} 的数组',
        'ArrayLenGeLe' => '“{{param}}”必须是长度在 {{min}} ~ {{max}} 之间的数组',

        // 文件
        'File' => '“{{param}}”必须是文件',
        'FileSize' => '“{{param}}”必须是文件, 且大小不超过{{size}}',
        'FileExt' => '“{{param}}”必须是.{{ext}}文件',
        'FileImage' => '“{{param}}”必须是图像文件(jpg,png,bmp,gif,ico,tiff)',
        'FileVideo' => '“{{param}}”必须是视频文件(mp4,rm,mov,avi)',
        'FileAudio' => '“{{param}}”必须是音频文件(mp3,wav,aac)',

//        // 关系型（似乎没有存在的必要）
//        'or' => '', // 或关系
        'Required' => '必须提供参数{{param}}',

//        // 其它
        'Object' => '“{{param}}”必须是对象',
        'Date' => '“{{param}}”必须符合日期格式YYYY-MM-DD',
        'Datetime' => '“{{param}}”必须符合日期时间格式YYYY-MM-DD HH:mm:ss',
        'Time' => '“{{param}}”必须符合时间格式HH:mm:ss或HH:mm',
        'Timestamp' => '“{{param}}”不是合法的时间戳',

        // 预处理（只处理字符串类型, 如果是其它类型, 则原值返回）
        'Trim' => '', // 对要检测的值先作一个trim操作, 后续的检测是针对trim后的值进行检测
        'Lowercase' => '', // 将要检测的值转为小写, 后续的检测是针对转换后的值进行检测
        'Uppercase' => '', // 将要检测的值转为大写, 后续的检测是针对转换后的值进行检测
        'ToInt' => '', // 预处理为int型
        'ToString' => '', // 预处理为string型（这个一般用不到）
    ];

    // 所有验证器格式示例
    static private $sampleFormats = [
        // 整型（不提供length检测,因为负数的符号位会让人混乱, 可以用大于小于比较来做到这一点）
        'Int' => 'Int',
        'IntEq' => 'IntEq:100',
        'IntGt' => 'IntGt:100',
        'IntGe' => 'IntGe:100',
        'IntLt' => 'IntLt:100',
        'IntLe' => 'IntLe:100',
        'IntGtLt' => 'IntGtLt:1,100',
        'IntGeLe' => 'IntGeLe:1,100',
        'IntGtLe' => 'IntGtLe:1,100',
        'IntGeLt' => 'IntGeLt:1,100',
        'IntIn' => 'IntIn:2,3,5,7,11',
        'IntNotIn' => 'IntNotIn:2,3,5,7,11',

        // 浮点型（内部一律使用double来处理）
        'Float' => 'Float',
        'Double' => 'Double', // 同float
        'FloatGt' => 'FloatGt:1.0',
        'FloatGe' => 'FloatGe:1.0',
        'FloatLt' => 'FloatLt:1.0',
        'FloatLe' => 'FloatLe:1.0',
        'FloatGtLt' => 'FloatGtLt:0,1.0',
        'FloatGeLe' => 'FloatGeLe:0,1.0',
        'FloatGtLe' => 'FloatGtLe:0,1.0',
        'FloatGeLt' => 'FloatGeLt:0,1.0',

        // bool型
        'Bool' => 'Bool', // 忽略大小写
        'BoolSmart' => 'BoolSmart',

        // 字符串
        'String' => 'String',
        'Len' => 'Len:8',
        'LenGe' => 'LenGe:8',
        'LenLe' => 'LenLe:8',
        'LenGeLe' => 'LenGeLe:6,8',
        'ByteLen' => 'ByteLen:8',
        'ByteLenGe' => 'ByteLenGe:8',
        'ByteLenLe' => 'ByteLenLe:8',
        'ByteLenGeLe' => 'ByteLenGeLe:6,8',
        'Letters' => 'Letters',
        'Alphabet' => 'Alphabet', // 同Letters
        'Numbers' => 'Numbers',
        'Digits' => 'Digits', // 同Numbers
        'LettersNumbers' => 'LettersNumbers',
        'Numeric' => 'Numeric',
        'VarName' => 'VarName',
        'Equals' => 'Equals:abc',
        'Email' => 'Email',
        'Url' => 'Url',
        'Ip' => 'Ip',
        'Mac' => 'Mac',
        'In' => 'In:abc,def,g',
        'NotIn' => 'NotIn:abc,def,g',
        'InNoCase' => 'InNoCase:abc,def,g',
        'NotInNoCase' => 'NotInNoCase:abc,def,g',
        'Regexp' => 'Regexp:/^abc$/', // Perl正则表达式匹配

        // 数组. 如何检测数组长度为0
        'Array' => 'Array',
        'ArrayLen' => 'ArrayLen:5',
        'ArrayLenGe' => 'ArrayLenGe:1',
        'ArrayLenLe' => 'ArrayLenLe:9',
        'ArrayLenGeLe' => 'ArrayLenGeLe:1,9',

        // 文件
        'File' => 'File',
        'FileSize' => 'FileSize:100kb',
        'FileExt' => 'FileExt',
        'FileImage' => 'FileImage',
        'FileVideo' => 'FileVideo',
        'FileAudio' => 'FileAudio',
        'FileMimes' => 'FileMimes:mpeg,jpeg,png',

//        // 关系型（似乎没有存在的必要）
//        'or' => '', // 或关系
        'Required' => 'Required',

        // 条件判断
        'If' => 'If:selected', // 值是否等于 1, true, '1', 'true', 'yes', 'y'(字符串忽略大小写)
        'IfNot' => 'IfNot:selected', // 值是否等于 0, false, '0', 'false', 'no', 'n'(字符串忽略大小写)
        'IfTrue' => 'IfTrue:selected', // 值是否等于 true 或 'true'(忽略大小写)
        'IfFalse' => 'IfFalse:selected', // 值是否等于 false 或 'false'(忽略大小写)
        'IfExist' => 'IfExist:var', // 参数 var 是否存在
        'IfNotExist' => 'IfNotExist:var', // 参数 var 是否不存在
        'IfIntEq' => 'IfIntEq:var,1', // if (type === 1)
        'IfIntNe' => 'IfIntNe:var,2', // if (state !== 2). 特别要注意的是如果条件参数var的数据类型不匹配, 那么If条件是成立的; 而其它几个IfIntXx当条件参数var的数据类型不匹配时, If条件不成立
        'IfIntGt' => 'IfIntGt:var,0', // if (var > 0)
        'IfIntLt' => 'IfIntLt:var,1', // if (var < 0)
        'IfIntGe' => 'IfIntGe:var,6', // if (var >= 6)
        'IfIntLe' => 'IfIntLe:var,8', // if (var <= 8)
        'IfIn' => 'IfIn:var,2,3,5,7', // if (in_array(var, [2,3,5,7]))
        'IfNotIn' => 'IfNotIn:var,2,3,5,7', // if (!in_array(var, [2,3,5,7]))
//        'IfSame' => 'IfSame:AnotherParameter',
//        'IfNotSame' => 'IfNotSame:AnotherParameter',
//        'IfAny' => 'IfAny:type,1,type,2', //待定

//        // 其它
        'Object' => 'Object',
        'Date' => 'Date',
        'DateFormat' => 'DateFormat:yyyy-dd-mm',
        'DateFrom' => 'DateFrom:2017-04-13',
        'DateTo' => 'DateTo:2017-04-13',
        'DateFromTo' => 'DateFromTo:2017-04-13,2017-04-13',
        'Datetime' => 'Datetime',
        'Time' => 'Time',
//        'Timestamp' => 'Timestamp',
        'TimeZone' => 'TimeZone:timezone_identifiers_list()',

        // 预处理（只处理字符串类型, 如果是其它类型, 则原值返回）
        'Trim' => 'Trim',
        'Lowercase' => 'Lowercase',
        'Uppercase' => 'Uppercase',
        'ToInt' => 'ToInt',
        'ToString' => 'ToString',
    ];

    /**
     * 将验证器(Validator)编译为验证子(Validator Unit)的数组
     *
     * 示例1:
     * 输入: $validator = 'Len:6,16|regex:/^[a-zA-Z0-9]+$/'
     * 输出: [
     *     ['Len', 6, 16, null, $alias],
     *     ['regex', '/^[a-zA-Z0-9]+$/', null, $alias],
     * ]
     *
     * 示例2（自定义验证失败的提示）:
     * 输入: $validator = 'Len:6,16|regex:/^[a-zA-Z0-9]+$/|>>>:参数验证失败了'
     * 输出: [
     *     'countOfIfs' => 0,
     *     'required' => false,
     *     'units' => [
     *         ['Len', 6, 16, '参数验证失败了', $alias],
     *         ['regex', '/^[a-zA-Z0-9]+$/', '参数验证失败了', $alias],
     *     ],
     * ]
     *
     * @param $validator string 一条验证字符串
     * @param $alias string 参数的别名. 如果验证器中包含Alias:xxx, 会用xxx取代这个参数的值
     * @return array 返回包含验证信息的array
     * @throws \Exception
     */
    private static function _compileValidator($validator, $alias)
    {
        if (is_string($validator) === false)
            throw new \Exception("编译Validator失败: Validator必须是字符串");;
        if (strlen($validator) === 0) {
            return [
                'countOfIfs' => 0,
                'required' => false,
                'units' => [],
            ];
        }

        $countOfIfs = 0; //Ifxxx的个数
//        $ifUnits = [];
        $required = false;
        $validatorUnits = [];

        $segments = explode('|', $validator);
        $segCount = count($segments);
        $customReason = null;
        for ($i = 0; $i < $segCount;) {
            $segment = $segments[$i];
            $i++;
            if (strpos($segment, 'Regexp:') === 0) // 是正则表达式
            {
                if (strpos($segment, '/') !== 7) // 非法的正则表达. 合法的必须首尾加/
                    throw new \Exception("正则表达式验证器regexp格式非法. 正确的格式是 Regexp:/xxxx/");

                $pos = 8;
                $len = strlen($segment);

                $finish = false;
                do {
                    $pos2 = strripos($segment, '/'); // 反向查找字符/
                    if ($pos2 !== $len - 1 // 不是以/结尾, 说明正则表达式中包含了|分隔符, 正则表达式被explode拆成了多段
                        || $pos2 === 7
                    ) // 第1个/后面就没字符了, 说明正则表达式中包含了|分隔符, 正则表达式被explode拆成了多段
                    {
                    } else // 以/结尾, 可能是完整的正则表达式, 也可能是不完整的正则表达式
                    {
                        do {
                            $pos = strpos($segment, '\\', $pos); // 从前往后扫描转义符\
                            if ($pos === false) // 结尾的/前面没有转义符\, 正则表达式扫描完毕
                            {
                                $finish = true;
                                break;
                            } else if ($pos === $len - 1) // 不可能, $len-1这个位置是字符/
                            {
                                ;
                            } else if ($pos === $len - 2) // 结尾的/前面有转义符\, 说明/只是正则表达式内容的一部分, 正则表达式尚未结束
                            {
                                $pos += 3; // 跳过“\/|”三个字符
                                break;
                            } else {
                                $pos += 2;
                            }
                        } while (1);

                        if ($finish)
                            break;
                    }

                    if ($i >= $segCount) // 后面没有segment了
                        throw new \Exception("正则表达式验证器格式错误. 正确的格式是 Regexp:/xxxx/");

                    $segment .= '|';
                    $segment .= $segments[$i]; // 拼接后面一个segment
                    $len = strlen($segment);
                    $i++;
                    continue;

                } while (1);

                $validatorUnits[] = ['Regexp', substr($segment, 7)];
            } // end if(strpos($segment, 'Regexp:')===0)
            else {
                $pos = strpos($segment, ':');
                if ($pos === false) {
                    if ($segment === 'Required') {
                        if (count($validatorUnits) > $countOfIfs)
                            throw new \Exception("Required只能出现在验证器的开头（IfXxx后面）");
                        $required = true;
                    } else
                        $validatorUnits[] = [$segment];
                } else {
                    $validatorName = substr($segment, 0, $pos);
                    $p = substr($segment, $pos + 1);
                    if (strlen($validatorName)===0 || strlen($p) === 0) {
                        if($validatorName !== '>>>')
                            throw new \Exception("无法识别的验证子“${segment}”");
                    }
                    switch ($validatorName) {
                        case 'IntEq':
                        case 'IntGt':
                        case 'IntGe':
                        case 'IntLt':
                        case 'IntLe':
                        case 'Len':
                        case 'LenGe':
                        case 'LenLe':
                        case 'ByteLen':
                        case 'ByteLenGe':
                        case 'ByteLenLe':
                        case 'ArrayLen':
                        case 'ArrayLenGe':
                        case 'ArrayLenLe':
                            if (self::_isIntOrIntString($p) === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, intval($p)];
                            break;
                        case 'IntGtLt':
                        case 'IntGeLe':
                        case 'IntGtLe':
                        case 'IntGeLt':
                        case 'LenGeLe':
                        case 'ByteLenGeLe':
                        case 'ArrayLenGeLe':
                            $vals = explode(',', $p);
                            if (count($vals) !== 2)
                                self::_throwFormatError($validatorName);
                            $p1 = $vals[0];
                            $p2 = $vals[1];
                            if (self::_isIntOrIntString($p1) === false || self::_isIntOrIntString($p2) === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, intval($p1), intval($p2)];
                            break;
                        case 'IntIn':
                        case 'IntNotIn':
                            $ints = self::_parseIntArray($p);
                            if ($ints === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $ints];
                            break;
                        case 'equals':
                            $p = trim($p);
                            if(strlen($p) === 0)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $p];
                            break;
                        case 'In':
                        case 'NotIn':
                        case 'InNoCase':
                        case 'NotInNoCase':
                            $strings = self::_parseStringArray($p);
                            if ($strings === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $strings];
                            break;
                        case 'IfIntEq':
                        case 'IfIntNe':
                        case 'IfIntGt':
                        case 'IfIntLt':
                        case 'IfIntGe':
                        case 'IfIntLe':
                            if(count($validatorUnits) > $countOfIfs)
                                throw new \Exception("IfXxx只能出现在验证器的开头");
                            $params = self::_parseIfXxxWith1Param1Int($p, $validatorName);
                            if ($params === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $params[0], $params[1]];
                            $countOfIfs ++;
                            break;
                        case 'IfIn':
                        case 'IfNotIn':
                            if(count($validatorUnits) > $countOfIfs)
                                throw new \Exception("IfXxx只能出现在验证器的开头");
                            $params = self::_parseIfXxxWith1ParamMultiValue($p);
                            if ($params === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $params[0], $params[1]];
                            $countOfIfs ++;
                            break;
                        case 'If':
                        case 'IfNot':
                        case 'IfExist':
                        case 'IfNotExist':
                        case 'IfTrue':
                        case 'IfFalse':
//                        case 'IfSame':
//                        case 'IfNotSame':
                            if(count($validatorUnits) > $countOfIfs)
                                throw new \Exception("IfXxx只能出现在验证器的开头");
                            $varname = self::_parseIfXxxWith1Param($p);
                            if ($varname === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, $varname];
                            $countOfIfs ++;
                            break;
//                        case 'IfAny':
//                            break;
                        case 'FloatGt':
                        case 'FloatGe':
                        case 'FloatLt':
                        case 'FloatLe':
                            if (is_numeric($p) === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, doubleval($p)];
                            break;
                        case 'FloatGtLt':
                        case 'FloatGeLe':
                        case 'FloatGtLe':
                        case 'FloatGeLt':
                            $vals = explode(',', $p);
                            if (count($vals) !== 2)
                                self::_throwFormatError($validatorName);
                            $p1 = $vals[0];
                            $p2 = $vals[1];
                            if (is_numeric($p1) === false || is_numeric($p2) === false)
                                self::_throwFormatError($validatorName);
                            $validator = [$validatorName, doubleval($p1), doubleval($p2)];
                            break;
                        case '>>>':
                            $customReason = $p;
                            // >>>:之后的所有字符都属于错误提示字符串
                            for (; $i < $segCount; $i++) {
                                $customReason .= '|' . $segments[$i];
                            }
                            $validator = null;
                            break;
                        case 'Alias':
                            if(strlen($p))
                                $alias = $p;
                            $validator = null;
                            break;
                        default:
                            throw new \Exception("无法识别的验证子“${segment}”");
                    }
                    if($validator)
                        $validatorUnits[] = $validator;
                } // end if 有冒号:分隔符
            } // end else 不是Regexp
        } // end for ($segments)

        if(!is_string($alias) || strlen($alias) === 0)
            $alias = 'UnknownParameter';
        for ($i = count($validatorUnits) -1 ; $i >= 0; $i--) {
            $validatorUnits[$i][] = $customReason;
            $validatorUnits[$i][] = $alias;
        }
        return [
            'countOfIfs' => $countOfIfs,
            'required' => $required,
            'units' => $validatorUnits,
        ];
    }

    private static function _throwFormatError($validatorName)
    {
        $sampleFormat = @self::$sampleFormats[$validatorName];
        if($sampleFormat === null)
            throw new \Exception("验证器${validatorName}格式错误");
        throw new \Exception("验证器${validatorName}格式错误, 正确的格式是: $sampleFormat");
    }

    private static function _isIntOrIntString($value)
    {
        return (is_numeric($value) && strpos($value, '.') === false);
    }

    /**
     * 将包含int数组的字符串转为int数组
     * @param $value
     * @return int[]|bool 如果是合法的int数组, 并且至少有1个int, 返回int数组; 否则返回false
     */
    private static function _parseIntArray($value)
    {
        $vals = explode(',', $value);
        $ints = [];
        foreach ($vals as $val) {
            if(is_numeric($val) === false || strpos($val, '.') !== false)
                return false; // 检测到了非int
            $ints[] = intval($val);
        }
        if(count($ints)===0)
            return false;
        return $ints;
    }

    /**
     * 将字符串转为字符串数组（逗号分隔）
     * @param $value
     * @return string[]|bool 如果至少有1个有效字符串, 返回字符串数组; 否则返回false
     */
    private static function _parseStringArray($value)
    {
        $vals = explode(',', $value);
        $strings = [];
        foreach ($vals as $val) {
            $val = trim($val);
            if(strlen($val) === 0)
                return false; // 检测到了非int
            $strings[] = $val;
        }
        if(count($strings)===0)
            return false;
        return $strings;
    }

    /**
     * 解析 IfXxx:varname,123 中的冒号后面的部分（1个条件参数后面带1个值）
     * @param $paramstr string
     * @param $validatorName string 条件验证子'IfIntXx'
     * @return array|false 出错返回false, 否则返回 ['varname', 123]
     * @throws \Exception
     */
    private static function _parseIfXxxWith1Param1Int($paramstr, $validatorName)
    {
        $params = explode(',', $paramstr);
        if (count($params) != 2)
            return false;

        $varName = $params[0];
        $value = $params[1];
        self::validateInt($value, "“$validatorName:${paramstr}”中“${varName}”后面必须是整数，实际上却是“${value}”");
        return [$varName, intval($value)];
    }

    /**
     * 解析 IfXxx:varname 中的冒号后面的部分（1个条件参数后面带0个值）
     * @param $paramstr string
     * @return string|false 出错返回false, 否则返回 'varname'
     * @throws \Exception
     */
    private static function _parseIfXxxWith1Param($paramstr)
    {
        $params = explode(',', $paramstr);
        if (count($params) != 1)
            return false;

//        $varName = $params[0];
        return $params[0];
    }

    /**
     * 解析 IfXxx:varname,1,2,3 中的冒号后面的部分（1个条件参数后面带多个变量）
     * @param $paramstr string
     * @return array|false 出错返回false, 否则返回 ['varname', ['1','2','3']]
     * @throws \Exception
     */
    private static function _parseIfXxxWith1ParamMultiValue($paramstr)
    {
        $params = explode(',', $paramstr);
        $c = count($params);
        if ($c <= 2)
            return false;

//        $varName = $params[0];
        $vals = [];
        for ($i = 1; $i < $c; $i++) {
            $vals[] = $params[$i];
        }
        return [$params[0], $vals];
    }

    /**
     * 验证一个值
     * @param $value mixed 要验证的值
     * @param $validator string|string[] 一条验证器, 例: 'Len:6,16|regex:/^[a-zA-Z0-9]+$/'; 或多条验证器的数组, 多条验证器之间是或的关系
     * @param string $alias 要验证的值的别名, 用于在验证不通过时生成提示字符串.
     * @param $ignoreRequired bool 是否忽略所有的Required检测子
     * @param array $originParams 原始参数的数组
     * @param array $siblings 与当前要检测的参数同级的全部参数的数组
     * @return mixed 返回$value被过滤后的新值
     * @throws \Exception
     */
    public static function validateValue($value, $validator, $alias = 'Parameter', $ignoreRequired = false, $originParams = [], $siblings = [])
    {
        if(is_array($validator)) {
            $validators = $validator;
        } else if(is_string($validator)) {
            $validators = [$validator];
        } else
            throw new \Exception(self::class . '::' . __FUNCTION__ . "(): \$validator必须是字符串或字符串数组");

        /*
         * 一个参数可以有一条或多条validator, 检测是否通过的规则如下:
         * 1. 如果有一条validator检测成功, 则该参数检测通过
         * 2. 如果即没有成功的也没有失败的（全部validator都被忽略或者有0条validator）, 也算参数检测通过
         * 3. 上面两条都不满足, 则参数检测失败
         */
        $success = 0;
        $failed = 0;
        foreach ($validators as $validator) {

            $validatorInfo = self::_compileValidator($validator, $alias);
            $validatorUnits = $validatorInfo['units'];
            try {

                $countOfIfs = $validatorInfo['countOfIfs'];
                $countOfUnits = count($validatorUnits);

                for ($i = 0; $i < $countOfIfs; $i++) {
                    $validatorUnit = $validatorUnits[$i];
//                    echo "\n".json_encode($validatorUnit)."\n";

                    $ifName = $validatorUnit[0];
                    $method = 'validate' . ucfirst($ifName);
                    if(method_exists(self::class, $method)===false)
                        throw new \Exception("找不到条件判断${$ifName}的验证方法");

                    $varkeypath = $validatorUnit[1]; // 条件参数的路径
                    // 提取条件参数的值
                    // todo 如果条件参数不存在, 应该视为忽略还是检测不通过?
                    if (strpos($varkeypath, '.') === 0) // 以.开头, 是相对路径
                    {
                        $key = substr($varkeypath, 1); // 去掉开头的.号
                        self::validateVarName($key, 'IfXxx中的条件参数不是合法的变量名');
                        $actualValue = @$siblings[$key];
                        $ancestorExist = true;
                    } else // 绝对路径
                    {
                        // 解析路径
                        $asterisksCount = 0;
                        $keys = self::_compileKeypath($varkeypath, $asterisksCount);
                        if ($asterisksCount > 0) {
                            throw new \Exception("IfXxx中的变量path不得包含*号");
                        }

                        $keysCount = count($keys);
                        $ancestorExist = false;
                        $actualValue = self::_getValue($originParams, $keys, $keysCount, $ancestorExist);
                    }

//                    echo "\n\$actualValue = $actualValue\n";
//                    echo "\n\$compareVal = $compareVal\n";

                    if ($ancestorExist == false) // 条件参数的父级不存在
                        break;
                    $compareVal = $validatorUnit[2];
                    $params = [$actualValue, $compareVal];
                    $trueOfFalse = call_user_func_array([self::class, $method], $params);
                    if ($trueOfFalse === false) // If条件不满足
                        break; // 跳出
                }

                if ($i < $countOfIfs) // 有If条件不满足, 忽略本条validator
//                {
//                    echo "\n不满足条件\n";
                    continue;
//                } else if ($countOfIfs)
//                    echo "\n满足条件\n";

                if($value === null) //没有提供参数
                {
                    if (($validatorInfo['required'] === false) || $ignoreRequired)
                        continue; // 忽略本条validator
                    else
                        $failed++;
                }

                for ($i = $countOfIfs; $i < $countOfUnits; $i++) {
                    $validatorUnit = $validatorUnits[$i];

                    $validatorUnitName = $validatorUnit[0];

                    $method = 'validate' . ucfirst($validatorUnitName);

//                    if ($countOfIfs) {
//                        echo "\n$method()\n";
//                    }

                    if(method_exists(self::class, $method)===false)
                        throw new \Exception("找不到验证子${validatorUnitName}的验证方法");

                    $params = [$value];
                    $paramsCount = count($validatorUnit);
                    for ($i = 1; $i < $paramsCount; $i++) {
                        $params[] = $validatorUnit[$i];
                    }

                    $value = call_user_func_array([self::class, $method], $params);
                }

                $success++;
                break; // 多个validator只需要一条验证成功即可
            } catch (\Exception $e) {
                $lastException = $e;
                $failed++;
            }
        }

        if($success || $failed === 0)
            return $value;

        if(isset($lastException))
            throw $lastException;
        throw new \Exception("“${alias}”验证失败"); // 这句应该不会执行
    }

    /**
     * @param $keypath string 路径
     * @param $asterisksCount int& 路径中包含星号(*)的个数
     * @return array
     * @throws \Exception
     */
    private static function _compileKeypath($keypath, &$asterisksCount)
    {
        if(strlen($keypath) === 0)
            throw new \Exception('$validations数组中包含空的字段名');

        if(preg_match('/^[a-zA-Z0-9_.\[\]*]+$/', $keypath) !== 1)
            throw new \Exception("非法的字段名“${keypath}”");

        $keys = explode('.', $keypath); // $keys中的数组还没有解析
        if(count($keys)===0)
            throw new \Exception('$validations数组中包含空的字段名');

        $asterisksCount = 0;

        $filteredKeys = [];
        // 尝试识别普通数组, 形如'varname[*]'
        foreach ($keys as $key) {
            if(strlen($key)===0)
                throw new \Exception("“${keypath}”中包含空的字段名");

            $i = strpos($key, '[');
            if($i === false) // 普通的key
            {
                if(strpos($key, '*') !== false)
                    throw new \Exception("“${keypath}”中'*'号只能处于方括号[]中");
                if(strpos($key, ']') !== false)
                    throw new \Exception("“${key}”中包含了非法的']'号");
                if(preg_match('/^[0-9]/', $key)===1) {
                    if(count($keys)===1)
                        throw new \Exception("字段名“${keypath}”不得以数字开头");
                    else
                        throw new \Exception("“${keypath}”中包含了以数字开头的字段名“${key}”");
                }
                $filteredKeys[] = $key;
                continue;
            } else if($i === 0) {
                throw new \Exception("“${keypath}”中'['号前面没有变量名");
            } else {
                $j = strpos($key, ']');
                if($j === false)
                    throw new \Exception("“${key}”中的'['号之后缺少']'");
                if($i>$j)
                    throw new \Exception("“${key}”中'[', ']'顺序颠倒了");

                // 识别普通数组的变量名（'[*]'之前的部分）
                $varName = substr($key, 0, $i);
                if(strpos($varName, '*') !== false)
                    throw new \Exception("“${key}”中包含了非法的'*'号");
                if(preg_match('/^[0-9]/', $varName)===1)
                    throw new \Exception("“${keypath}”中包含了以数字开头的字段名“${varName}”");
                $filteredKeys[] = $varName;

                // 识别普通数组的索引值
                $index = substr($key, $i+1, $j-$i-1);
                if($index === '*') {
                    $filteredKeys[] = $index;
                    $asterisksCount++;
                } else if(is_numeric($index))
                    $filteredKeys[] = intval($index);
                else
                    throw new \Exception("“${key}”中的方括号[]之间只能包含数字或'*'号");

                // 尝试识别多维数组
                $len = strlen($key);
                while($j < $len - 1) {
                    $j++;
                    $i = strpos($key, '[', $j);
                    if($i !== $j)
                        throw new \Exception("“${key}”中的“[$index]”之后包含非法字符");
                    $j = strpos($key, ']', $i);
                    if($j === false)
                        throw new \Exception("“${key}”中的'['号之后缺少']'");

                    $index = substr($key, $i+1, $j-$i-1);
                    if($index === '*') {
                        $filteredKeys[] = $index;
                        $asterisksCount++;
                    } else if(is_numeric($index))
                        $filteredKeys[] = intval($index);
                    else
                        throw new \Exception("“${key}”中的方括号[]之间只能包含数字或'*'号");
                }
            }
        }
        return $filteredKeys;
    }

    /**
     * 验证输入参数
     *
     * 如果客户端通过HTTP协议要传递的参数的值是一个空Array或空Object, 实际上客户
     * 端HTTP协议是会忽略这种参数的, 服务器接收到的参数数组中也就没有相应的参数.
     * 举例, 如果客户端传了这样的参数: {
     *     "bookname": "hello,world!",
     *     "authors": [],
     *     "extra": {},
     * }
     * 服务器接收到的实际上会是: {
     *     "bookname": "hello",
     * }
     * 没有authors和extra参数
     *
     * @param $params array 包含输入参数的数组. 如['page'=>1,'pageSize'=>10]
     * @param $validations array 包含验证字符串的数组. 如: [
     *     'keypath1' => 'validator string',
     *     'bookname' => 'Len:2',
     *     'summary' => 'Len:0',
     *     'authors' => 'Required|Array',
     *     'authors[*]' => 'Required|Object',
     *     'authors[*].name' => 'Len:2',
     *     'authors[*].email' => 'Regexp:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+.[a-z]+$/',
     * ]
     * @param $ignoreRequired bool 是否忽略所有的Required检测子
     * @return mixed
     * @throws \Exception 验证不通过会抛出异常
     */
    public static function validate($params, $validations, $ignoreRequired = false)
    {
        if(is_array($params) === false)
            throw new \Exception(self::class . '::' . __FUNCTION__ . "(): \$params必须是数组");

        $cachedKeyValues = [];
        foreach ($validations as $keypath => $validator) {

            // 解析路径
            $asterisksCount = 0;
            $keys = self::_compileKeypath($keypath, $asterisksCount);

            $keysCount = count($keys);
            if($keysCount>1 && $cachedKeyValues === null)
                $cachedKeyValues = [];

            self::_validate($params, $keys, $keysCount, $validator, '', $ignoreRequired, $cachedKeyValues);
        }
//        if(count($cachedKeyValues))
//            echo json_encode($cachedKeyValues, JSON_PRETTY_PRINT);
        return $params;
    }

    /**
     * 根据路径从参数数组中取值. 可以用于Ifxxx中参数的取值
     * @param $params array
     * @param $keys array
     * @param $keysCount int
     * @param $ancestorExist bool&
     * @param string $keyPrefix
     * @param $cachedKeyValues array&|null
     * @return null|mixed
     * @throws \Exception
     */
    private static function _getValue($params, $keys, $keysCount, &$ancestorExist, $keyPrefix = '', &$cachedKeyValues = null)
    {
        $keyPath = $keyPrefix;
        $siblings = $params;
        $value = $params;

        if ($keysCount > 1) {
            // 查询缓存
            if ($cachedKeyValues !== null) {

                // todo 如果没有*号, 没必要重新合成路径
                $prefix = $keyPrefix;
                for ($i = 0; $i < $keysCount - 1; $i++) {
                    $key = $keys[$i];
                    if ($prefix === '')
                        $prefix = $key;
                    else if (is_integer($key) || $key === '*')
                        $prefix .= "[$key]";
                    else
                        $prefix .= ".$key";
                }

                if (array_key_exists($prefix, $cachedKeyValues)) {
                    echo "\n命中: key=$prefix" . ", value=" . $cachedKeyValues[$prefix] . "\n";
                }
            }
        }

        for ($n = 0; $n < $keysCount; $n++) {
            $siblings = $value;
            $keyPrefix = $keyPath;

            $key = $keys[$n];
            if ($key === '*') {
                Validation::validateArray($siblings, null, $keyPrefix);
                $c = count($siblings);
                if ($c > 0) {
                    $subKeys = array_slice($keys, $n + 1);
                    $subKeysCount = $keysCount - $n - 1;

                    if ($subKeysCount) // *号后面还有keys
                    {
                        $values = [];
                        $ancestorExist = false;
                        for ($i = 0; $i < $c; $i++) {
                            $element = $siblings[$i];
                            $keyPath = $keyPrefix . "[$i]";
                            $aAncestorExist = false;
                            $aValue = self::_getValue($element, $subKeys, $subKeysCount, $aAncestorExist, $keyPath, $cachedKeyValues);
                            if ($aAncestorExist) {
                                $values[] = $aValue;
                                $ancestorExist = true;
                            }
//                            self::_validate($element, $subKeys, $subKeysCount, $validator, $keyPath, $ignoreRequired, $cachedKeyValues);
                        }
                    } else // *号是最后一级
                    {
                        $values = $siblings;

                        // todo 缓存数组本身的没什么用, 因为提取不到.
                        if ($cachedKeyValues !== null && $keyPrefix) {
                            $cachedKeyValues[$keyPrefix] = $siblings;
//                            echo "\n缓存: keyPrefix=$keyPrefix, key=$keyPath" . ", value=$siblings\n";
                        }
                    }
                    return $values;
                } else // 'items[*]' => 'Required' 要求items至少有1个元素, 但上面的循环不检测items==[]的情况
                    $value = null; // 这里是针对$value==[]这种情况的特殊处理
            } else {
                if (is_integer($key))
                    Validation::validateArray($siblings, null, $keyPrefix);
                else
                    Validation::validateObject($siblings, null, $keyPrefix);
                $value = @$siblings[$key];
            }

            if ($keyPrefix === '')
                $keyPath = $key;
            else if (is_integer($key) || $key === '*')
                $keyPath = $keyPrefix . "[$key]";
            else
                $keyPath = "$keyPrefix.$key";

            if ($value === null) {
                $n++;
                break;
            }
        }

        // 到这里$n表示当前的$value是第几层. 取值在[1, $keysCount]之间, 也就是说 $n 只可能小于或等于$keysCount
        if ($n == $keysCount) {
            $ancestorExist = true;
        } else {
            $ancestorExist = false;
            if ($cachedKeyValues !== null) {
                for (; $n < $keysCount; $n++) {
                    $keyPrefix = $keyPath;

                    $key = $keys[$n];

                    if ($keyPrefix === '')
                        $keyPath = $key;
                    else if (is_integer($key) || $key === '*')
                        $keyPath = $keyPrefix . "[$key]";
                    else
                        $keyPath = "$keyPrefix.$key";
                }
                $siblings = null;
            }
        }
        if ($cachedKeyValues !== null && $keyPrefix) {
            $cachedKeyValues[$keyPrefix] = $siblings; // 将父级数据缓存起来
//            echo "\n缓存: keyPrefix=$keyPrefix, key=$keyPath" . ", value=$siblings\n";
        }
        return $value;
    }

    /**
     * 验证一条Validation
     * @param $params array
     * @param $keys array
     * @param $keysCount int
     * @param $validator string
     * @param string $keyPrefix
     * @param $cachedKeyValues array|null 缓存已取过的值. 存储格式为: ['key1' => val1, 'key2' => val2]
     * @param $ignoreRequired bool 是否忽略所有的Required检测子
     * @throws \Exception
     */
    private static function _validate($params, $keys, $keysCount, $validator, $keyPrefix = '', $ignoreRequired = false, &$cachedKeyValues = null)
    {
        $keyPath = $keyPrefix;
        $siblings = $params;
        $value = $params;

        if($keysCount>1) {
            if($cachedKeyValues !== null) {
                $prefix = $keyPrefix;
                for ($i = 0; $i < $keysCount - 1; $i++) {
                    $key = $keys[$i];
                    if ($prefix === '')
                        $prefix = $key;
                    else if (is_integer($key) || $key === '*')
                        $prefix .= "[$key]";
                    else
                        $prefix .= ".$key";
                }

//                if(array_key_exists($prefix, $cachedKeyValues)) {
//                    echo "\n命中: key=$prefix" . ", value=".json_encode($cachedKeyValues[$prefix])."\n";
//                }
            }
        }

        for ($n = 0; $n < $keysCount; $n++) {
            $siblings = $value;
            $keyPrefix = $keyPath;

            $key = $keys[$n];
            if($key === '*') {
                Validation::validateArray($siblings, null, $keyPrefix);
                $c = count($siblings);
                if ($c > 0) {
                    $subKeys = array_slice($keys, $n + 1);
                    $subKeysCount = $keysCount - $n - 1;
                    for ($i = 0; $i < $c; $i++) {
                        $element = $siblings[$i];
                        $keyPath = $keyPrefix . "[$i]";
                        if($subKeysCount)
                            self::_validate($element, $subKeys, $subKeysCount, $validator, $keyPath, $ignoreRequired, $cachedKeyValues);
                        else {
                            Validation::validateValue($element, $validator, $keyPath, $ignoreRequired, $params, $siblings);

                            // 缓存数组本身的没什么用, 因为提取不到.
                            if($cachedKeyValues !== null && $keyPrefix) {
                                $cachedKeyValues[$keyPrefix] = $siblings;
//                                echo "\n缓存: keyPrefix=$keyPrefix, key=$keyPath" . ", value=$siblings\n";
                            }
                        }
                    }
                    return;
                }
                else // 'items[*]' => 'Required' 要求items至少有1个元素, 但上面的循环不检测items==[]的情况
                    $value = null; // 这里是针对$value==[]这种情况的特殊处理
            }
            else {
                if(is_integer($key))
                    Validation::validateArray($siblings, null, $keyPrefix);
                else
                    Validation::validateObject($siblings, null, $keyPrefix);
                $value = @$siblings[$key];
            }

            if($keyPrefix === '')
                $keyPath = $key;
            else if(is_integer($key) || $key === '*')
                $keyPath = $keyPrefix."[$key]";
            else
                $keyPath = "$keyPrefix.$key";
            if($value === null) {
                $n++;
                break;
            }
        }

        // 到这里$n表示当前的$value是第几层
        if($n == $keysCount) {
            Validation::validateValue($value, $validator, $keyPath, $ignoreRequired, $params, $siblings);
        }
        else {
            if($cachedKeyValues !== null) {
                for (; $n < $keysCount; $n++) {
                    $keyPrefix = $keyPath;

                    $key = $keys[$n];

                    if ($keyPrefix === '')
                        $keyPath = $key;
                    else if (is_integer($key) || $key === '*')
                        $keyPath = $keyPrefix . "[$key]";
                    else
                        $keyPath = "$keyPrefix.$key";
                }
                $siblings = null;
            }
        }
        if($cachedKeyValues !== null && $keyPrefix) {
            $cachedKeyValues[$keyPrefix] = $siblings;
//            echo "\n缓存: keyPrefix=$keyPrefix, key=$keyPath" . ", value=$siblings\n";
        }
    }

}