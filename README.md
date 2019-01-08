# README

## PHP
* 5.6+

## PHP EXT
* openssl

## Usage
* php example.php

## Output
```
You may copy these two keys into .env:
#################################
INSTANCE_KEY=JDJ5JDEwJHV6ZWpCMlR6TjhGTml5MTN0djVHUi51T0xUd2pxMGNwM1BremRiS0tkcmVwRWlpZlVhQVBP
DB_PASSWORD_KEY=aFBPbnZJS2NpK1QvT09pb01hYWJNQT09
#################################

valid successfully, db_password=12345678AbC, db_password_2=12345678AbC

DB Password From Keys: 12345678AbC
```

## addition
* 相关 KEY 存在环境变量或内存更加安全
* 虽然通过脚本可轻易执行获得相关信息, 但避免明文密码存放可为应急响应止损争取时间, 抵御初级入侵, 脚本扫描等