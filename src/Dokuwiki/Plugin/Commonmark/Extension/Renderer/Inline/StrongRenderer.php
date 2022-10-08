<?php

/*
 * This file is part of the clockoon/dokuwiki-commonmark-plugin package.
 *
 * (c) Sungbin Jeon <clockoon@gmail.com>
 *
 * Original code based on the followings:
 * - CommonMark JS reference parser (https://bitly.com/commonmark-js) (c) John MacFarlane
 * - league/commonmark (https://github.com/thephpleague/commonmark) (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DokuWiki\Plugin\Commonmark\Extension\Renderer\Inline;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Strong;

final class StrongRenderer implements NodeRendererInterface
{
    /**
     * @param Strong                   $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $DWRenderer)
    {
        if (!($inline instanceof Strong)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        return '**' .  $DWRenderer->renderNodes($inline->children()) . '**';
    }
}
