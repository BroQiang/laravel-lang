# 自定义语言包

网上已经有了多个语言库，但是不太满足个人使用，按照个人习惯定义了语言包,
发布到 packagist，方便 下次创建项目的时候直接 composer 安装

本包绝大多数代码参考: [https://github.com/overtrue/laravel-lang](https://github.com/overtrue/laravel-lang)

## 使用方法

暂时只有两种语言，因为本人不需要其他语言，如果需要多语言参考 overtrue 的仓库

因为语言包发布完了这个插件就没有用了，所以通过 `--dev` 只给开发环境安装即可

```shell
composer require --dev broqiang/laravel-lang

php artisan lang:publish zh-CN,en
```

