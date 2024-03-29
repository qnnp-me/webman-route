<?php
/**
 * This file is part of webman-auto-route.
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    qnnp<qnnp@qnnp.me>
 * @copyright qnnp<qnnp@qnnp.me>
 * @link      https://main.qnnp.me
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Qnnp\WebmanRoute\Attribute\OpenAPI;

/**
 * @link https://swagger.io/specification/#example-object 规范文档
 */
class example {
  /**
   * <div style="color:#E97230;">string</div>
   */
  const summary = 'summary';
  /**
   * <div style="color:#E97230;">string</div>
   */
  const description = 'description';
  /**
   * <div style="color:#E97230;">Any</div>
   */
  const value = 'value';
  /**
   * <div style="color:#E97230;">string</div>
   * <span style="color:#E97230;">示例 URL ，和 value 互斥。</span>
   */
  const externalValue = 'externalValue';
}
