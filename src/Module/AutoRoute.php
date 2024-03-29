<?php
/*
 * This file is part of webman-auto-route.
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    qnnp<qnnp@qnnp.me>
 * @copyright qnnp<qnnp@qnnp.me>
 * @link      https://qnnp.me
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Qnnp\WebmanRoute\Module;

use Exception;
use Qnnp\WebmanRoute\Attribute\Route as RouteAttribute;
use ReflectionClass;
use ReflectionException;


class AutoRoute
{
  /**
   * @var bool $openapi <span style="color:#E97230;">是否生成 OpenAPI 文档</span>
   */
  protected static bool $openapi = true;
  protected static bool $appLoaded = false;
  protected static bool $openapiLoaded = false;

  /**
   * <h2 style="color:#E97230;">加载注解路由</h2>
   * <span style="color:#E97230;">/app 默认自动加载</span>
   *
   * @param array $list <span style="color:#E97230;">需要另外加载的目录</span>
   *                    <pre style="color:#E97230;">[ [命名空间根, 目录绝对路径], ...array]</pre>
   *
   * @param bool $openapi <span style="color:#E97230;">OpenAPI 文档开关（默认：true）</span>
   *
   * @throws ReflectionException
   */
  static function load(array $list = [], bool $openapi = true): void
  {
    static::$openapi = $openapi;
    $class_list = [];
    if (!self::$appLoaded) {
      self::$appLoaded = true;
      // 扫描 /app 目录所有可用文件
      static::scanClass('\app', app_path(), $class_list);
    }
    if (!self::$openapiLoaded && $openapi) {
      self::$openapiLoaded = true;
      // 扫描 OpenAPI 文件
      static::scanClass(
        'Qnnp\WebmanRoute\Controller',
        dirname(__DIR__) . '/Controller',
        $class_list
      );
    }
    // 扫描给定的目录列表中所有可用类
    foreach ($list as $item) {
      static::scanClass($item[0], $item[1], $class_list);
    }
    // 扫描给定的目录列表中所有可用路由
    foreach ($class_list as $class => $namespace) {
      static::scanRoute($class, $namespace);
    }
  }

  /**
   * <h2 style="color:#E97230;">扫描目录存在的类</h2>
   *
   * @param string $base_namespace <span style="color:#E97230;">对应的命名空间根</span>
   * @param string $dir_path <span style="color:#E97230;">目录</span>
   * @param array $class_list <span style="color:#E97230;">引用列表</span>
   */
  protected static function scanClass(string $base_namespace, string $dir_path, array &$class_list): void
  {
    $dir_path = realpath($dir_path);
    /**
     * 读取PHP文件列表
     */
    $files = static::scanFiles($dir_path);
    /**
     * 扫描类
     */
    foreach ($files as $file) {
      /** 拼接类名 */
      $class = str_replace("/", '\\', str_replace($dir_path, $base_namespace, preg_replace("/\.php$/i", '', $file)));
      /** 确定类存在 */
      if (class_exists($class)) {
        $class_list[$class] = $base_namespace;
      }
    }
  }

  /**
   * <h2 style="color:#E97230;">扫描目录所有PHP文件</h2>
   * <div style="color:#E97230;">排除 . 开头的文件夹和 model,view 文件夹</div>
   *
   * @param string $dir_path <span style="color:#E97230;">扫描的目录</span>
   *
   * @return array
   */
  protected static function scanFiles(string $dir_path): array
  {
    $files = [];
    if (is_dir($dir_path)) {
      $dir_path = realpath($dir_path);
      $items = scandir($dir_path);
      foreach ($items as $item) {
        $item_path = $dir_path . DIRECTORY_SEPARATOR . $item;
        if (!preg_match("/^(^\..*|model|view|middleware)$/", $item) && is_dir($item_path)) {
          array_push($files, ...static::scanFiles($item_path));
        } elseif (preg_match("/\.php$/i", $item) && preg_match("/controller/i", $item_path)) {
          $files[] = $item_path;
        }
      }
    }
    return $files;
  }

  /**
   * <h2 style="color:#E97230;">扫描所有注解路由</h2>
   *
   * @param string $class <span style="color:#E97230;">类名</span>
   * @param string $namespace <span style="color:#E97230;">基本命名空间</span>
   *
   * @throws ReflectionException
   * @throws Exception
   */
  protected static function scanRoute(string $class, string $namespace): void
  {
    /** 给定类的反射类 */
    $ref_class = new ReflectionClass($class);
    /** 获取类里的所有方法 */
    $methods = $ref_class->getMethods();
    /** 遍历类方法 */
    foreach ($methods as $method) {
      /** 读取方法的路由注解 */
      $attributes = $method->getAttributes(RouteAttribute::class);
      /** 遍历方法的所有路由 */
      foreach ($attributes as $attribute) {
        /**
         * 路由对象
         *
         * @var RouteAttribute $route
         */
        $route = $attribute->newInstance();
        /** 设置的路由对象的参数列表 */
        $arguments = $attribute->getArguments();
        /** 读取路由Path */
        $path = preg_replace("/^\.\//", '', $arguments[0] ?? $arguments['route'] ?? '');
        if ($path === '') {
          $path = $method->name === 'index' ? '' : $method->name;
        }
        // 路由对应方法
        $callback = $ref_class->name . '@' . $method->name;
        /** 相对路径子路由处理 */
        if (!preg_match("/^[\/\\\]/", $path)) {
          // 驼峰转换
          $base_path = strtolower(preg_replace("/([a-z0-9])([A-Z])/", "$1-$2", $ref_class->name));
          $base_namespace = strtolower(preg_replace("/([a-z0-9])([A-Z])/", "$1-$2", $namespace));
          // 反斜杠处理
          $base_path = str_replace('\\', '/', $base_path);
          $base_namespace = str_replace('\\', '/', $base_namespace);
          $base_namespace = preg_replace('/^\//', '', $base_namespace); // 去除用户可能携带的开头斜杠
          // 去除基本命名空间开头
          $base_path = str_replace($base_namespace, '', $base_path);
          // 路径中移除 controller 目录
          $base_path = str_replace('/controller', '', $base_path);
          // 路径中移除 index 类名
          $base_path = str_replace('/index', '', $base_path);
          // 拼接实际路径
          $path = $base_path . (empty($path) ? '' : '/' . $path);
        }
        $path = preg_replace('/-controller/', '', $path);
        // 驼峰转换
        $path = strtolower(preg_replace("/([a-z0-9])([A-Z])/", "$1-$2", $path));
        /** 设置路由路径 */
        $route->path = $path;
        /** 添加路由 */
        $route->add($callback);
        /** 添加到 OpenAPI 文档 */
        static::$openapi && $route->addToOpenAPI();
      }
    }
  }
}
