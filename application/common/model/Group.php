<?php
/**
 * Description: 管理组类文件.
 * Author: momo
 * Date: 2019-10-26
 * Copyright: momo
 */

namespace app\common\model;


class Group extends Base
{
    public function __construct($data = ['id'=>0,'group_name'=>'','group_info'=>''])
    {
        parent::__construct($data);
    }
}
