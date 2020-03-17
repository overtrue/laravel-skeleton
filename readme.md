# Laravel API 基础模板

开箱即用的 Laravel API 基础结构。

## 特点
- 基于 Airlock 的授权机制；
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

### 模型关系加载
我们可以在前端请求时动态决定接口返回哪些模型关系，例如 `User` 模型有一个 `posts` 关系，我们的用户列表控制器如下 `UserController@index`:

```php
public function index(Request $request)
{
    $users = User::filter($request->all())
        ->with($request->includes())   // <---
        ->latest()
        ->paginate($request->get('per_page', 20));

    return Resource::collection($users);
}
```

默认不会返回 `posts` 关系，当前端请求的 URL 如下时将会返回：
```
http://laravel-skeleton.test/api/users?include=posts
```

如果期望返回指定的字段，则可以这样构造 URL：
```
http://laravel-skeleton.test/api/users?include=posts:id,title,updated_at
```

这样返回结果中 `posts` 结果将只包含 `id,title,updated_at` 。
> 注意：这里不能省略掉关系的 id 字段，否则关系将无法正常加载。  

### 模型搜索功能
项目已经内置的基本的搜索支持，您只需要在模型引入 `App\Traits\Filterable`，然后配置 `filterable`属性即可：

```php
use use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use Filterable;

	protected $filterable = [
    'user_id', 'category_id', 'version', 
  ];
}
```

控制器开启搜索功能，只需要调用 `filter()` 方法即可：

```php
public function index(Request $request)
{
    $posts = Post::with($request->includes())
                ->latest()
                ->filter() // <---
                ->paginate($request->get('per_page'));

    return Resource::collection($posts);
}
```

URL 中只需要传递对应的参数值即可：

```
http://laravel-skeleton.test/api/posts?include=user:id,username&user_id=123&category_id=4
// &user_id=123&category_id=4
```

#### 自定义搜索
默认使用相等查询，如果需要自定义搜索字段，直接在模型中添加 `filterXXX` 方法实现，比如我们想实现文章标题模糊查询：

```php
public function filterTitle($query, $keyword)
{
    $query->where('title', 'like', "%{$keyword}%");
}
```

然后 URL 上使用 `title=关键字` 就能实现模糊查询了。
> 当然，你也可以定义模型中不存在的字段。  

### 静默更新
我们有时候会想更新数据库中的记录，但是不希望出发 `updated_at` 更新，则可以在模型引入 `App\Traits\QuietlySave` 或者 `App\Traits\QuietlyUpdate` 这两个 trait：

```php
// App\Traits\QuietlySave
User::saveQuietly([...]); 
// or
// App\Traits\QuietlyUpdate
User::updateQuietly([...]); 
```

### 内置接口

#### 用户登录（获取 token）

##### POST /api/login

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
	"token_type": "bearer",
	"token":"oVFV407i4jSTxjFO2tNxzh8lDaxVLbIkZZiDwjgMSYhvvkbUUXw8y0XgeYtxLAp4paznq0oxSMDdXmco"
}
```

#### 用户注册
##### POST /api/register

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
	"token_type": "bearer",
	"token":"oVFV407i4jSTxjFO2tNxzh8lDaxVLbIkZZiDwjgMSYhvvkbUUXw8y0XgeYtxLAp4paznq0oxSMDdXmco"
}
```

#### 登出
##### POST /api/logout

+ Request (`application/json`)
		+ Headers
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1...
```
+ Response 204

#### 获取当前登录用户
##### GET /api/user

+ Request (`application/json`)
		+ Headers
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1...
```
+ Response 200 (`application/json`)

```json
{
  "id": 1,
  "creator": 0,
  "username": "admin",
  "name": "\u8d85\u7ea7\u7ba1\u7406\u5458",
  "real_name": null,
  "avatar": "\/img\/default-avatar.png",
  "email": null,
  "gender": "none",
  "phone": null,
  "birthday": null,
  "status": "active",
  "cache": [],
  "properties": null,
  "settings": [],
  "is_admin": true,
  "last_active_at": null,
  "last_refreshed_at": null,
  "frozen_at": null,
  "status_remark": null,
  "email_verified_at": null,
  "created_at": "2020-03-17T09:37:45.000000Z",
  "updated_at": "2020-03-17T09:37:45.000000Z",
  "deleted_at": null
}
```

#### 获取站点设置

##### GET /api/settings

- Response 200 (`application/json`)

```json
{
    "demo": {
        "status":"it works!"
    }
}
```

## License
MIT
