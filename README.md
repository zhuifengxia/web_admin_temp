#网站模板 , 基于TP5.1

##使用到的第三方类库
######工具类库
安装类库,在跟目录运行`composer require 'mo/mo-common:dev-master'`

######验证码类库
安装类库，在根目录运行`composer require topthink/think-captcha=2.0.*`

######微信类库（PHP>=7.0）
安装类库,在跟目录运行`composer require overtrue/wechat:~4.0 -vvv`

######excel导出类库
安装类库,在根目录运行`composer require phpoffice/phpspreadsheet`

######日志记录类库
安装类库，在根目录运行`composer require psr/log`

###代码规范
* 目录使用小写+下划线；
* 类文件采用驼峰法命名（首字母大写），其它文件采用小写+下划线命名；
* 类的命名采用驼峰法（首字母大写），例如 User、UserType;
* 方法的命名使用驼峰法（首字母小写），例如 getUserName；
* 属性的命名使用驼峰法（首字母小写），例如 tableName;
* 常量以大写字母和下划线命名;
* 数据表和字段采用小写加下划线方式命名;