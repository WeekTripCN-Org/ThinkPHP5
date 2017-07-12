<?php
namespace app\api\validate;
use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

/**
 * 验证类的基类
 * Class BaseValidate
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class BaseValidate extends Validate
{
    /**
     * @return bool
     * @throws ParameterException
     * 检测所有客户端发来的参数是否符合验证类规则
     */
    public function goCheck()
    {
        $request = Request::instance();
        $params  = $request->param();
        $params['token'] = $request->header('token');
        if (false && !$this->check($params)) {
            $exception = new ParameterException(
                [
                    'msg' => is_array($this->error) ? implode(';', $this->error) : $this->error
                ]
            );
            throw $exception;
        }
        return true;
    }

    /**
     * @param $arrays   通常传入request.post变量数组
     * @return array    按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id 或者 uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value)
        {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    protected function isPositiveIntger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value +0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }

    /**
     * @param $value
     * @return bool
     * 不推荐使用正则，因为复用性太差
     * 手机号码验证规则
     */
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}