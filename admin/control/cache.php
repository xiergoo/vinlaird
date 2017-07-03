<?php
/**
 * 清理缓存
 ***/

defined('InShopNC') or exit('Access Invalid!');

class cacheControl extends SystemControl
{
    protected $cacheItems = array(
        'setting',          // 基本缓存
    );

    public function __construct()
    {
        parent::__construct();
        Language::read('cache');
    }

    /**
     * 清理缓存
     */
    public function clearOp()
    {
        if (!chksubmit()) {
            Tpl::showpage('cache.clear');
            return;
        }

        $lang = Language::getLangContent();

        // 清理所有缓存
        if ($_POST['cls_full'] == 1) {
            foreach ($this->cacheItems as $i) {
                dkcache($i);
            }

            // 表主键
            Model::dropTablePkArrayCache();


            // 首页
            //Model('web_config')->getWebHtml('index', 1);
            delCacheFile('index');
        } else {
            $todo = (array) $_POST['cache'];

            foreach ($this->cacheItems as $i) {
                if (in_array($i, $todo)) {
                    dkcache($i);
                }
            }

            // 表主键
            if (in_array('table', $todo)) {
                Model::dropTablePkArrayCache();
            }

            // 首页
            if (in_array('index', $todo)) {
                //Model('web_config')->getWebHtml('index', 1);
                //delCacheFile('index');
            }
        }

        $this->log(L('cache_cls_operate'));
        showMessage($lang['cache_cls_ok']);
    }
}
