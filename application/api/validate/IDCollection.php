<?php
namespace app\api\validate;
/**
 * Class IDCollection
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (!$this->isPositiveIntger($id)) {
                return false;
            }
        }
        return true;
    }

    protected function checkIDs1($value, $rule, $data)
    {
        $result = true;
        $values = explode(',', $value);
        if (empty($values)) {
            $result = false;
        }
        array_walk($values, function($id) use (&$result) {
            if (!$this->isPositiveIntger($id)) {
                $result = false;
            }
        });
        return $result;
    }
}