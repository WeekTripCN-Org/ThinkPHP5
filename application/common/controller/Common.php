<?php
namespace app\common\controller;
use think\Controller;
use think\Lang;

/**
 * Class Common
 * @package \app\common\controller
 * @author  weektrip@weektrip.cn
 */
class Common extends Controller
{
    public function _initialize()
    {
        $now_lang = $this->getSetLang();
        $this->assign('set_lang', $now_lang);
    }

    public function getSetLang()
    {
        $lang = Lang::detect();
        if ($lang == 'zh-cn') {
            return 'en-us';
        }
        return 'zh-cn';
    }
}