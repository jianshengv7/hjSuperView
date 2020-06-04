# superview

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install

Via Composer

``` bash
$ composer require "njxzwh/superview @dev"
```

## Usage
``` php
SuperView::setConfig($configs);
SuperView::get('soft')->recent();
```

### 使用缓存
缓存默认使用全局配置`cache_minutes`, 如果需要为单独的请求设置缓存时间, 可以使用cache方法, 参数为分钟.
``` php
SuperView::get('soft')->cache(10)->recent();
```
如果需要修改所有的查询都为设置的缓存时间, 可以使用第二个参数, 缓存时间将一直保留, 直到下一次设置cache.
``` php
SuperView::get('soft')->cache(10, true)->recent();
SuperView::get('soft')->recent(); //仍然使用上面的缓存时间

SuperView::get('soft')->cache(20)->recent(); //使用新的缓存时间, 并且只在当前调用中
```

### 使用分页
#### 所有支持limit参数的方法都可以使用分页
第一个参数用来生成分页的url, 应该与路由格式保持一致.
第二个参数指定当前分页.
``` php
SuperView::get('soft')->page('list-{page}.html', $page)->recent();
```
使用指定分页和自定义的布局, 第二个参数指定分页, 第三个参数指定是否使用简洁模式(默认`false`), 第四个参数参考Configs下的`pagination`.
``` php
SuperView::get('soft')->page('list-{page}.html', 2, false,
    [
        'layout' => '<ul>{total}{previous}{links}{next}</ul>',
        'total' => '<li class="pipe">共{total}页</li>',
        'previous' => '<li href="{url}">上一页</li>',
        'links' => '<li href="{url}">{page}</li>',
        'link_active' => '<li class="on">{page}</li>',
        'next' => '<li href="{url}">下一页</li>',
        'dots' => '<li">...</li>',
    ])->recent();
```
返回数据格式:
``` php
[
  "count" => "594",
  "list" => [],
  "page" => ""
]
```
仅分页数据, 不需要返回`page`和`count`, 第一个参数设置为`false`.
``` php
SuperView::get('soft')->page(false, 2)->recent();
SuperView::get('soft')->page(false)->recent(); // 默认为第一页, 作用相当于不使用page方法
```

## Configs
```
[
    'api_base_url' => 'http://api.base.url',
    'cache_minutes' => 120, // 通用缓存时间, 单位: 分 默认120分钟, 如果设置为0则不使用缓存, 但是所有的分类数据依然使用缓存, 如果需要更新分类缓存可以设置refresh_cache.
    'refresh_cache' => 1, // 刷新所有方法的缓存, 1是, 0否, 默认0
    'class_url' => '/{channel}/{classname}/{classid}{page}.html', //支持参数列表
    'info_url' => '/{channel}/{classname}/{classid}/{id}.html', //支持参数列表
    'pagination' => [
        'layout' => '<div class="pages pt-20">{total}{previous}{links}{next}</div>',
        'total' => '<span class="pipe">共{total}页</span>',
        'previous' => '<a href="{url}">上一页</a>',
        'links' => '<a href="{url}">{page}</a>',
        'link_active' => '<a class="on">{page}</a>',
        'next' => '<a href="{url}">下一页</a>',
        'dots' => '<span class="pipe">...</span>',
    ],
]
```

## 模型名称
| 支点        | 模型名
|------------|---------------------------------------------
| category   | ['category']
| soft       | ['soft', 'iossoft', 'iosgame', 'game', 'dnb', 'azsoft', 'azgame']
| news       | ['aznews', 'iosnews', 'softnews', 'kjnews', 'ylnews', 'gamenews', 'dnbnews', 'smsnews']
| zt         | ['zt']

## Api
### category 分类模块

#### 1. info($classid)
获取分类信息

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 是    | null    |

#### 2. finalChildren($classid, $limit)
获取子终极分类

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 是    | null    |
| limit         | 每页数据量,0为不限制                | 否    | 0       |

#### 3. children($classid, $limit)
获取下一级子分类

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 是    | null    |
| limit         | 每页数据量,0为不限制                | 否    | 0       |

#### 4. brothers($classid)
获取同级兄弟分类

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 是    | null    |

#### 5. breadcrumbs($classid)
获取分类的面包屑

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 是    | null    |

#### 6. search($name, $classid)
根据分类名称搜索分类(模糊查询)

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| name          | 分类名称                            | 是    | null    |
| classid       | 分类ID, 搜索该分类下的分类          | 否    | 0       |

#### 7. classPath($classpath)
通过classpath获取分类信息

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classpath          |        classpath                    | 是    | null    |

#### 8.finalFather($classid)
通过classid获取顶级分类

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid          |        分类id                    | 是    | 0    |

#### 9.classTbname($tbname)
通过tbname获取分类信息

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| tbname          |        tbname                    | 是    | 0    |




### content 内容模块
使用具体的`channel`名称, 只有不确定`channel`才使用`content`(目前只有`superTopic`方法支持使用`content`)

#### 1. order($classid, $limit, $order)
排序列表

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 否    | 0       |
| limit         | 每页数据量,0为不限制                | 否    | 0       |
| order         | 排序字段                          | 否    | newstime       |

#### 2. info($id)
获取内容信息

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| id            | 信息ID                              | 是    | null    |

#### 3. recent($classid, $limit, $isPic)
获取最新内容列表

参数:
| 参数名        | 描述                                | 必填  | 默认    |
| ------------- | ----------------------------------- | :---: | :-----: |
| classid       | 分类ID                              | 否    | 0       |
| limit         | 每页数据量,0为不限制                | 否    | 0       |
| isPic         | 是否只查询带图片的数据, 1是, 0否    | 否    | 0       |

#### 4. good($level, $classid, $limit, $isPic, $order)
获取推荐列表

参数:
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| level         | 置顶等级, 0 - 9(0为不置顶)                   | 否    | 0        |
| classid       | 分类ID                                       | 否    | 0        |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| isPic         | 是否只查询带图片的数据, 1是, 0否             | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 5. top($level, $classid, $limit, $isPic, $order)
获取置顶列表

参数:
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| level         | 置顶等级, 0 - 9(0为不置顶)                   | 否    | 0        |
| classid       | 分类ID                                       | 否    | 0        |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| isPic         | 是否只查询带图片的数据, 1是, 0否             | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 6. firsttitle($level, $classid, $limit, $isPic, $order)
获取头条列表

参数:
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| level         | 置顶等级, 0 - 9(0为不置顶)                   | 否    | 0        |
| classid       | 分类ID                                       | 否    | 0        |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| isPic         | 是否只查询带图片的数据, 1是, 0否             | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 7. superTopic($topicId, $limit)
获取专题信息列表, 如果无法指定`channel`, 使用该方法获取该专题下的所有`channel`的内容，否则直接使用topic方法

参数:
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| topicId       | 专题ID                                       | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |

#### 8. count($period, $classid)
获取统计数量

参数:
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| period        | 周期,'day','week','month','all'              | 否    | all      |
| classid       | 分类ID                                       | 否    | 0        |

#### 9.strategy( $game_id, $limit, $orders)
通过game_id获取攻略列表

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| game_id       | id                                   | 是    | 0     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | lastdotime |

#### 10.customList($fields, $limit, $order, $operator)
自定义参数请求（多个参数以逗号分隔，多个值以逗号分隔，参数和值数量必须对应）

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| fileds        | 参数    ['a'=>1, 'b'=>2]                                 | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |
| operator      | 拼接条件                                     | 否 | and|

#### 11.infoTopics($id, $limit)
获取信息所属专题列表

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| id         |  软件id                                    | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |

#### 12.getHotSearchForClass（$classid， $limit）
内联词数据获取（4个关键词）

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         |  软件id                                    | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |

#### 13.matchQuery($type, $limit, $order)
特殊条件查询（and | or 同时存在）

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| type         |  种类                                  | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |
| order         |  排序                                     | 是    | newstime     |

#### 14.allOrder($table, $limit, $order)
关联查询的order方法

参数：
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| table         |  表名                                  | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |
| order         |  排序                                     | 是    | newstime     |

#### 15.today（$classid, $limit, $order）
通过天查询

参数：
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         |  分类id                                  | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |
| order         |  排序                                     | 是    | newstime     |

#### 16.matchJoinQuery($type)
预定义数据查询关联表 用于特殊数据获取

参数：
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| type         |  分类                                  | 是    | 1     |

#### 17.getHotSearch（$classid， $limit）
内联词获取数据不够其他内联词补足

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         |  软件id                                    | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |

#### 18.matchPl($fields, $limit, $order)
获取评论

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| fields         |  条件                                    | 是    | 0     |
| limit         |  每页数据量, 需要大于1,0为不限制                                      | 是    | 0     |
| order         |  排序                                     | 是    | saytime     |

#### 19.condition($classid, $type, $value)
id条件查询 (id > or >= or <= or <)

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         |  classid                                  | 是    | 0     |
| type         |  种类                                      | 是    | >   |
| value         |  值                                     | 是    | ''     |

#### 20.getRecommend($classid, $softid, $limit)
获取推荐词

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         |  classid                                  | 是    | 0     |
| softid         |  软件id                                      | 是    | 0   |
| limit         |       每页数据量, 需要大于1,0为不限制                               | 是    | 10    |


### zt 专题模块

#### 0. good($showzt, $classid, $limit, $order)
获取推荐专题
参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| showzt          | 推荐专题                                   | 否    | 0        |
| classid         | 分类ID                                       | 否    | 0        |
| limit           | 每页数据量,0为不限制                         | 否    | 0        |
| order           | 排序字段                                     | 否    | addtime  |


#### 1. index($topicCategoryId, $classid, $limit, $order)
获取专题列表

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| topicCategoryId | 专题分类ID                                   | 否    | 0        |
| classid         | 分类ID                                       | 否    | 0        |
| limit           | 每页数据量,0为不限制                         | 否    | 0        |
| order           | 排序字段                                     | 否    | addtime  |

#### 2. info($id, $path)
获取专题信息

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| id              | 专题ID                                       | 是    | null     |
| path            | 专题路径, 例如: /zt/qq                       | 否    | ''       |

#### 3. categories()
获取所有专题分类列表


#### 4. recentInClass($classid, $limit, $order)
ios/安卓屏道页定制专题

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid        | 分类ID                                                 | 是    | 0     |
| limit            | 每页数据量,0为不限制                       | 否    | 0      |
| order            | 排序字段                      | 否    | addtime      | 

#### 5.listInIdClassId($id, $classid, $limit)
dnb 详情页专题定制方法 （通过软件id和classid获取列表）

参数:
| 参数名           | 描述                                          | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid         | 分类ID                                        | 是    | 0     |
| limit           | 每页数据量,0为不限制                            | 否    | 0      |
| id              | 软件id                                        | 是    | 0      | 


#### 6.matchZt($fields, $limit, $order, $database)
自定义参数请求（参数和值数量必须对应,关联查询）

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| fields        | 参数 和值      ['name'=>'tom', 'id'=>1]                              | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 7.match($fields, $limit, $order)
自定参数请求（不需要关联查询）

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| fields        | 参数 和值 ['name'=>'tom', 'id'=>1]                                | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 8.softByZtid($fields, $order)
通过ztid获取soft和ztinfo信息(关联查询)

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| fields        | 参数                                | 是    | null     |
| order         | 排序                         | 否    | addtime        |

#### 9.ztCommon（$ids, $limit, $group）
专题详情页评论 (关联查询)

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| ids        | 参数  数组                              | 是    | null     |
| limit         | 排序                                | 否    | null        |
| group         | 排序                                | 是    | null        |

#### 10.inZtid($ztid)
获取多个ztid数据

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| ztid        | ztid                                         | 是    | []     |

#### 11.getIdByZid($ztid)
ztinfo表通过ztid获取id

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| ztid        | ztid                               | 是    | 0     |

#### 13.ztaddJoinzt($fields, $limit, $order)
ztadd & zt表关联信息  (参数前缀 定死为zt , ztadd)

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| fields        | 参数  ['a'=>1,'b'=>2]                              | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | newstime |

#### 14.ztPl($pubid, $limit, $order)
zt获取评论

参数：
| 参数名        | 描述                                         | 必填  | 默认     |
| ------------- | -------------------------------------------- | :---: | :------: |
| pubid        | publid                           | 是    | null     |
| limit         | 每页数据量,0为不限制                         | 否    | 0        |
| order         | 排序字段                                     | 否    | saytime |



### utils 工具模块

#### 1. relationWord($softid)
获取软件相关词

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| softid            | 软件id              | 否    | 0        |


#### 2. renderPage($route, $total, $limit, $page, $simple, $options)
获取专题列表

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| route           | 分页url规则                                  | 是    | null     |
| total           | 数据总量                                     | 是    | null     |
| limit           | 每页数据量, 需要大于1,0为不限制              | 是    | null     |
| page            | 初始分页数                                   | 否    | 1        |
| simple          | 是否使用简洁模式                             | 否    | false    |
| options         | 数组, 参考Configs下的pagination              | 否    | 20       |

#### 3.friendLink($classid, $field, $home)
友链

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| classid           | 分类id                                  | 是    | 0     |
| field           |  数组                                   | 是    | []     |
| home           |  is_home              | 是    | ''     |


### comment 评论模块
#### 1.comment($id, $limit, $order)
获取评论

参数:
| 参数名          | 描述                                         | 必填  | 默认     |
| --------------- | -------------------------------------------- | :---: | :------: |
| id              | 软件id                                       | 是    | 0     |
| order           | 排序                                         | 否    | saytime     |
| limit           | 每页数据量, 需要大于1,0为不限制              | 是    | null     |


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Security

If you discover any security related issues, please email huangyukun@njxzwh.com instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/xzwh/superview.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/xzwh/superview/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/xzwh/superview.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/xzwh/superview.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/xzwh/superview.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/xzwh/superview
[link-travis]: https://travis-ci.org/xzwh/superview
[link-scrutinizer]: https://scrutinizer-ci.com/g/xzwh/superview/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/xzwh/superview
[link-downloads]: https://packagist.org/packages/xzwh/superview
[link-author]: https://coding.net/u/huangyukun
[link-contributors]: ../../contributors
