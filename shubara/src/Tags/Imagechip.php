<?php
namespace MediaWiki\Extension\Shubara\Tags;

use MediaWiki\Parser\Parser;
use MediaWiki\Parser\PPFrame;
use MediaWiki\Html\Html;
use MediaWiki\Extension\Shubara\Utils;

/**
* Render the imagechip tag
*/
// TODO: finish this
class Imagechip {
    /**
     * @param string $input What is supplied between the HTML tags. This gets evaluated
     * so it get spit out as normal wikitext
     * @param array $args HTML tag attribute params. Valid params:
     * - background-color: a CSS color for the card. #DEADBE by default
     * - href: where the button redirects
     * - target: link type, internal or external
     * - flex: sets the flex CSS value
     * @param Parser $parser MediaWiki Parser object
     * @param PPFrame $frame MediaWiki PPFrame object
     */
    public static function run($input, array $args, Parser $parser, PPFrame $frame) {
        $id = Utils::generateRandomString();
        $htmlAttributes = [
            'class' => 'ext-shubara-imagechip',
            'id' => "ext-shubara-$id",
        ];
        $styles = [];
        $content = '';
        
        $mode = $args['mode'] ?? 'col';
        // BUG: this is a GLARING SECURITY ISSUE you can just slap any CSS in there and
        // it will work. I will have to add some sanitization later on
        $backgroundColor = $args['background-color'] ?? '#DEADBE';
        array_push($styles, "background-color: $backgroundColor;");
        // list($r1, $g1, $b1) = Utils::hexColorToRgb($backgroundColor);
        // $content .= "$r1, $g1, $b1 ";
        // $hsv = Utils::rgbToHsv($r1, $g1, $b1);
        // $content .= implode(',', $hsv);
        // $content .= ' ';
        // $hsv['s'] *= 100.0;
        // $hsv['v'] *= 100.0;
        // $hsv['v'] += 40;
        // $content .= implode(',', $hsv);
        // $content .= ' ';
        // list($r2, $g2, $b2) = $borderColorRgb = Utils::hsvToRgb($hsv['h'], $hsv['s'], $hsv['v']);
        // $content .= "$r2, $g2, $b2 ";
        // $borderColor = Utils::rgbToHexColor($r2, $g2, $b2);
        // $content .= $borderColor;
        $borderColor = Utils::adjustBrightness($backgroundColor, 0.5);
        array_push($styles, "border: 4px solid $borderColor;");
    
        if (isset($args['flex']) && is_numeric(@$args['flex'])) {
            $flex = @$args['flex'];
            array_push($styles, "flex: $flex;");
        }

        $rawStyles = implode("\n", $styles);
        Utils::embedStyle("#ext-shubara-$id { $rawStyles }", $parser, $content);
    
        $content .= $parser->recursiveTagParse($input, $frame);

        return Html::rawElement('div', $htmlAttributes, $content);
    }
}
