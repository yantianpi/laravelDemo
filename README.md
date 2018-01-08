# laravel
本项目主要是为了学习laravel框架写的例子，内容基本和monitor一样，一些monitor未完成的管理界面功能在这里做了个简单实现。脚本任务暂未纳入到例子中

## 项目介绍
虽然在monitor中有做过介绍，这里还是再简单说一下，项目的初衷是想对一些有规律执行的任务进行统一分配，管理以及监控。本项目只提供底层架构，用户可根据各自需求进行差异化设置，互不影响；定制属性，生成配置项，只需要编写针对某类功能的执行脚本就可以运行。
比如说页面监控脚本的需求，监控的页面不同，监控的项也不同，有的监控页面是否返回200，有的监控页面是否包含黑白名单，有的监控返回的数据大小，有的监控页面的响应时间，有的需要传递参数，有的需要进行二次登陆，监控的页面也会不定时更新，另外监控需要通知，通知形式可以很多，比如短信，邮件，qq，微信，msn等。本项目可以满足以上各类纷繁需求，通知暂支持邮件通知设定，可扩展。


## 功能列表

* 分类管理，不同类型的任务使用分类区分，一个分类拥有一个特定任务处理脚本，一个分类下有若干可定制属性，供用户配置
* 属性管理，一个分类下拥有若干属性，每个属性支持默认通知消息
* 邮件管理，邮件通知的邮箱管理
* 批量执行任务时间管理，对时间点要求不是很高的任务可以和其他任务共享某一次执行，可设置每次处理的量（吞吐量）
* 任务管理，每一项配置好的任务会生成一条任务项，一条任务项代表某个具体的任务，包含监控的内容，监控的时间，通知方式，内容
* 日志，记录任务的执行情况，记录的添加，更新情况

## 样例截图
首页
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/index.png)
分类页
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/category.png)
属性页
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/attribute.png)
批量时间管理页
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/batch.png)
任务相关
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/task.png)
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/taskdetail.png)
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/taskedit.png)
日志
![image](https://github.com/yantianpi/laravelDemo/raw/master/public/images/log.png)


## 安装说明

系统需要安装Git,Php和MySQL，composer。

获取源码

	$ git clone git@github.com:yantianpi/laravelDemo.git

数据库创建

    创建数据库

初始化.env配置文件,增加数据库配置

    copy .env.example .env
    修改配置文件

下载依赖，生成key

    composer install
    php artisan key:generate

数据库迁移，初始化数据填充

    数据迁移 php artisan migrate
    数据填充 php artisan db:seed
    or
    回滚或创建（适合重构） php artisan migrate:refresh --seed

配置服务器
	
	配置相关服务器，根目录指到public。访问即可

待完善

    任务详情弹出层，通知类型如果是邮件，没有将用户id转换为邮箱；执行脚本暂未纳入系统