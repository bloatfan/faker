# 给数据库批量添加假数据

## 使用介绍

1. 在`database\config.php`脚本中配置数据库连接，目前只支持mysql数据库

2. 在`app\Seeds`目录下面新建一个模型类，此模型类需继承`\App\Seeds\Model`  
  这个基类。例如下面的`User`类


```User.php
<?php

namespace App\Seeds;

class User extends Model
{
    // 需指定此模型关联的表
    public $table = 'users';

    // 指定表中是否有 created_at和updated_at时间戳字段
    public $timestamps = true;

    // 重写基类的seed方法，指定数据格式
    public function seed(Faker $faker)
    {
        /*
         * 假设users表中有以下几个字段
         */
        return [
            'username' => $faker->name,
            'email' => $faker->email,
            'password' => password_hash('123456')
        ]
    }
}

```

3. 在`public\index.php`脚本中, 执行下面代码

```index.php

// 创建一个数据的工厂
$factory = new \App\Factory();
// 创建一个种子模型，参数为要创建的数据条数
$user = new \App\Seeds\User(10);

// 执行下面代码，即可在数据库中创建10条记录
$factory->create($user);

```

4. 关于faker的使用帮助  
    [faker](https://github.com/fzaninotto/Faker#fakerproviderlorem)