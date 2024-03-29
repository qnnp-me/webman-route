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
 * @link https://swagger.io/specification/#schema-object 规范文档
 */
class schema {
  const type                 = 'type';
  const allOf                = 'allOf';
  const oneOf                = 'oneOf';
  const anyOf                = 'anyOf';
  const not                  = 'not';
  const items                = 'items';
  const properties           = 'properties';
  const additionalProperties = 'additionalProperties';
  const description          = 'description';
  const format               = 'format';
  const default              = 'default';

  const title            = 'title';
  const multipleOf       = 'multipleOf';
  const maximum          = 'maximum';
  const exclusiveMaximum = 'exclusiveMaximum';
  const minimum          = 'minimum';
  const exclusiveMinimum = 'exclusiveMinimum';
  const maxLength        = 'maxLength';
  const minLength        = 'minLength';
  const pattern          = 'pattern';
  const maxItems         = 'maxItems';
  const minItems         = 'minItems';
  const uniqueItems      = 'uniqueItems';
  const maxProperties    = 'maxProperties';
  const minProperties    = 'minProperties';
  const required         = 'required';
  const enum             = 'enum';


  /**
   * <div style="color:#E97230;">boolean</div>
   */
  const nullable = 'nullable';
  /**
   * <div style="color:#E97230;">Discriminator Object</div>
   *
   * @see discriminator
   */
  const discriminator = 'discriminator';
  /**
   * <div style="color:#E97230;">XML Object</div>
   *
   * @see xml
   */
  const xml = 'xml';
  /**
   * <div style="color:#E97230;">External Documentation Object</div>
   *
   * @see externalDocs
   */
  const externalDocs = 'externalDocs';
  /**
   * <div style="color:#E97230;">Any</div>
   */
  const example = 'example';
  /**
   * <div style="color:#E97230;">boolean</div>
   */
  const readOnly = 'readOnly';
  /**
   * <div style="color:#E97230;">boolean</div>
   */
  const writeOnly = 'writeOnly';
  /**
   * <div style="color:#E97230;">boolean</div>
   */
  const deprecated = 'deprecated';
}
