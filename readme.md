# Laravel API 基础模板

开箱即用的 Laravel API 基础结构。
> 🚨自己用的哈，仅供参考，不提供咨询解答服务。

## 特点
- DDD（领域模型驱动）结构；
- 内置生成器，一键生成模块；
- 内置 laravel/sanctum 的授权机制；
- 高度完善的控制器、模型、模块模板；
- 集成常用基础扩展；
- 内置模型通用高阶 Traits 封装;
- 自动注册 Policies；
- 内置用户系统和基础接口；
- 内置管理后台接口；

## 安装

1. 创建项目

```bash
$ composer create-project overtrue/laravel-skeleton -vvv
```


2. 创建配置文件

```bash
$ cp .env.example .env
```

3. 创建数据表和测试数据

```bash
$ php artisan migrate --seed
```

> 这一步将会创建管理员账号 `username:admin / password:changeThis!!`  和一个 demo 设置项。  

然后访问 `http://laravel-skeleton.test/api/settings` 将会看到演示的设置项信息。 


## 使用

### 创建新领域

```shell script
php artisan make:domain Post 
```

> 该命令将会创建 `domain/Post` 目录，包含 `Actions`, `Models`, `Policies`, `Filters` 等目录。

### 创建领域类

所有官方的生成命令都增加了 `-d` 参数，用于指定领域名称，例如：

```shell
php artisan make:model Post -d Post
```
另外，还有一些自定义的生成命令：

```shell script
php artisan make:action MarkPostAsDraft -d Post
```

### 创建应用类

```shell script
php artisan make:app Post
php artisan make:endpoint GetPost -a Post
php artisan make:middleware MustBePublished -a Post
php artisan make:request CreatePost -a Post
php artisan make:resource Post -a Post
```

### 内置接口

#### 用户登录（获取 token）

##### POST /api/auth/login

+ Request (`application/json`)
```json
{
  "username": "admin",
  "password": "changeThis!!"
}
```
+ Response 200 (application/json)
```json
{
    "type": "bearer",
    "token":"oVFV407i4jSTxjFO2tNxzh8lDaxVLbIkZZiDwjgMSYhvvkbUUXw8y0XgeYtxLAp4paznq0oxSMDdXmco"
}
```

#### 用户注册
##### POST /api/auth/register

+ Request (`application/json`)
```json
{
   "username": "demo",
   "password": "123456"
}
```
+ Response 200 (`application/json`)
```json
{
    "type": "bearer",
    "token":"oVFV407i4jSTxjFO2tNxzh8lDaxVLbIkZZiDwjgMSYhvvkbUUXw8y0XgeYtxLAp4paznq0oxSMDdXmco"
}
```

#### 登出
##### POST /api/auth/logout

+ Request (`application/json`)
        + Headers
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1...
```
+ Response 204

#### 获取当前登录用户
##### GET /api/me

+ Request (`application/json`)
        + Headers
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1...
```
+ Response 200 (`application/json`)

```json
{
  "id": 1,
  "username": "admin",
  "nickname": "超级管理员",
  "avatar": "\/img\/default-avatar.png",
  "email": null,
  "gender": "none",
  "phone": null,
  "birthday": null,
  "settings": [],
  "is_admin": true,
  "last_active_at": null,
  "last_refreshed_at": null,
  "banned_at": null,
  "email_verified_at": null,
  "created_at": "2020-03-17T09:37:45.000000Z",
  "updated_at": "2020-03-17T09:37:45.000000Z",
  "deleted_at": null
}
```

## :heart: Sponsor me 

If you like the work I do and want to support it, [you know what to do :heart:](https://github.com/sponsors/overtrue)

如果你喜欢我的项目并想支持它，[点击这里 :heart:](https://github.com/sponsors/overtrue)

## Project supported by JetBrains

Many thanks to Jetbrains for kindly providing a license for me to work on this and other open-source projects.

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/overtrue)

## License
MIT
