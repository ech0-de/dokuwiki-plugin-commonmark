<?php

declare(strict_types=1);

/*
 * This file is part of the clockoon/dokuwiki-commonmark-plugin package.
 *
 * (c) Sungbin Jeon <clockoon@gmail.com>
 *
 * Original code based on the followings:
 * - CommonMark JS reference parser (https://bitly.com/commonmark-js) (c) John MacFarlane
 * - league/commonmark (https://github.com/thephpleague/commonmark) (c) Colin O'Dell <colinodell@gmail.com>
 * - Commonmark Table extension  (c) Martin Hasoň <martin.hason@gmail.com>, Webuni s.r.o. <info@webuni.cz>, Colin O'Dell <colinodell@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DokuWiki\Plugin\Commonmark\Extension\Renderer\Block;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Extension\Table\TableSection;

final class TableSectionRenderer implements NodeRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $DWRenderer, bool $inTightList = false)
    {
        if (!$block instanceof TableSection) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        if (!$block->hasChildren()) {
            return '';
        }

        $result = $DWRenderer->renderBlocks($block->children());
        return $result;

    }
}
