<?php
/**
 * Description: 路由表类文件.
 * Author: momo
 * Date: 2019-10-26
 * Copyright: momo
 */

namespace app\common\model;


class Rules extends Base
{
    public function __construct($data = ['id'=>0,'rule_name'=>'','rule_str'=>'','pid'=>0])
    {
        parent::__construct($data);
    }
}
