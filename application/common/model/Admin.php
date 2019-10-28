<?php
/**
 * Description: 管理员类文件.
 * Author: momo
 * Date: 2019-10-26
 * Copyright: momo
 */

namespace app\common\model;


class Admin extends Base
{
    public function __construct($data = ['id'=>0,'user_name'=>'','user_pwd'=>'','group_id'=>0])
    {
        parent::__construct($data);
    }
}
