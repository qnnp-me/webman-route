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
 * @link https://swagger.io/specification/#link-object 规范文档
 */
class link {
  const operationRef = 'operationRef';
  const operationId  = 'operationId';
  const parameters   = 'parameters';
  const requestBody  = 'requestBody';
  const description  = 'description';
  const server       = 'server';
  // TODO
}
