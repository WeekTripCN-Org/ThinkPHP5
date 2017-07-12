<?php
namespace app\api\controller\v1;
use app\lib\exception\MissException;
use think\Controller;

/**
 * Class Miss
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Miss extends Controller
{
    public function miss()
    {
        throw new MissException();
    }
}