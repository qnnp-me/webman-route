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
 * @link https://swagger.io/specification/#discriminator-object 规范文档
 */
class discriminator {
  /**
   * <div style="color:#E97230;">string 必须</div>
   */
  const propertyName = 'propertyName';
  /**
   * <div style="color:#E97230;">Map[string, string]</div>
   */
  const mapping = 'mapping';
}
