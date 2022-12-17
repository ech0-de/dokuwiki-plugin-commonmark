<?php

namespace Dokuwiki\Plugin\Commonmark;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Parser\MarkdownParser;
use Dokuwiki\Plugin\Commonmark\Extension\CommonmarkToDokuwikiExtension;
use Dokuwiki\Plugin\Commonmark\Extension\FootnoteToDokuwikiExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use Dokuwiki\Plugin\Commonmark\Extension\TableExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

class Commonmark {
    public static function RendtoDW($markdown, $frontmatter_tag = 'off'): string {
        # create environment
        $environment = self::createDWEnvironment();
        
        # create parser
        $parser = new MarkdownParser($environment);
        # create Dokuwiki Renderer
        $DWRenderer = new DWRenderer($environment);

        # separate frontmatter and main text
        $FMresult = self::ExtractFrontmatter($markdown);
        $frontmatter = $FMresult->getFrontMatter();
        $markdownOnly = $FMresult->getContent();
        $tagStr = ''; # initialize tag string
        //print_r($frontmatter);

        # extract tags only
        if(!empty($frontmatter)) {
            $tags = $frontmatter['tags'];
            $tagStr = "{{tag>";
            foreach ($tags as $tag) {
                $tagStr = $tagStr. "\"". $tag. "\" ";
            }
            $tagStr = $tagStr. "}}";
            //echo $tagStr;    
        }

        $document = $parser->parse($markdownOnly);
        $renderResult = $DWRenderer->renderNode($document);

        if($frontmatter_tag == 'off') {
            return $renderResult;
        } elseif($frontmatter_tag == 'upper') {
            return $tagStr."\n\n".$renderResult;
        } else {
            return $renderResult."\n\n".$tagStr;
        }
    }

    // Temporary implementation: separate method for frontmatter extraction
    // Since som parsed frontmatter info must be included in main text, it should be merged
    public static function ExtractFrontmatter($markdown) {
        $frontMatterExtension = new FrontMatterExtension();
        $result = $frontMatterExtension->getFrontMatterParser()->parse($markdown);

        return $result;
    }

    public static function createDWEnvironment(): Environment {
        $config = [];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkToDokuWikiExtension());
        $environment->addExtension(new FootnoteToDokuwikiExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new FrontMatterExtension());

        $environment->mergeConfig([
            'html_input' => 'strip',
        ]);

        return $environment;
    }
}

?>