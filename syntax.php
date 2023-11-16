<?php

/**
 * Mikio Plugin
 * 
 * @version 1.0
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */

if (!defined('DOKU_INC')) { die(); }

class syntax_plugin_simplequiz extends DokuWiki_Syntax_Plugin {
    public function getType() {
        return 'substition';
    }

    // public function getPType() {
        // return 'block';
    // }

    public function getSort() {
        return 100;
    }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('{{simplequiz::.+?}}', $mode, 'plugin_simplequiz');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler){
        $data = array();
        $matches = array();
        preg_match('/{{simplequiz::(\w+)(?: ?(.+))?}}/', $match, $matches);
        $data['cmd'] = $matches[1];
        $label = array();

        foreach (explode(' ', $matches[2]) as $match) {
            $pos = strpos($match, '=');
            if ($pos !== false && strlen($match) > 1) {
                $data[substr($match, 0, $pos)] = substr($match, $pos + 1);
            } else {
                $label[] = $match; // Add to temporary array
            }
        }
        
        $data['label'] = implode(' ', $label);

        return $data;
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml'){
            switch($data['cmd']) {
                case 'option':
                    if(isset($data['label'])) {
                        $score = isset($data['score']) ? $data['score'] : '0';
                        $group = isset($data['group']) ? $data['group'] : '0';
                        $renderer->doc .= '<input type="radio" name="simplequiz_group_'.$group.'" data-score="'.$score.'">'.$data['label'];
                        return true;
                    }
                    return false;
                case 'reveal':
                    $group = isset($data['group']) ? $data['group'] : '0';
                    $renderer->doc .= '<p class="simplequiz_reveal" data-group="'.$group.'"><span class="simplequiz_reveal_title">Score: </span><span class="simplequiz_reveal_value"></span></p>';
                    return true;
                case 'show':
                    $renderer->doc .= '<input type="button" class="simplequiz_reveal" value="Show Scores">';
                    return true;
            }
    
            return true;
        }
        return false;
    }
}