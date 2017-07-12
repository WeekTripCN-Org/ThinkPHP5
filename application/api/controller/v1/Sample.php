<?php
namespace app\api\controller\v1;

use app\api\model\Auth;
use app\api\validate\SampleGet;
use app\lib\exception\MissException;
use think\Controller;
use app\api\service\Sample as SampleService;
use think\Request;

/**
 * Class Sample
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Sample extends Controller
{
    public function getSample($key)
    {
        $validate = new SampleGet();
        $validate->goCheck();

        $key = (int) $key;
        $result = SampleService::getSampleByKey($key);
        if (empty($result)) {
            throw new MissException([
               'msg' => 'sample not found'
            ]);
        }
        return $result;
    }

    public function test1()
    {
        $users = Auth::with(['hi' => function($query){
            $query->where('id', '>', 2);
        }])->find(1);
        return $users;
    }

    public function test2($id = 1)
    {
        $n = input('param.');
        Request::instance()->get(['name' => 10]);
        echo input('get.name');
    }

    public function test3()
    {
        $n = input('param.');
        $m = input('post.');
    }
}