<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Brend Wanders <b.wanders@utwente.nl>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die('Meh.');

/**
 * The relativedate type.
 */
class plugin_strata_type_relativedate extends plugin_strata_type {
    function relative_time($time, $basis=null) {
        $scales = array(
            'second' => 60,
            'minute' => 60,
            'hour' => 24,
            'day' => 7,
            'week' => 4,
            'month' => 12,
            'year' => PHP_INT_MAX
        );

        if($basis == null) $basis = time();

        $delta = $basis - $time;
        $future = ($delta < 0);
        $delta = abs($delta);

        if($delta < 10) {
            return $future ? 'momentarily' : 'just now';
        }

        foreach($scales as $scale=>$factor) {
            if($delta == 0) {
                return $future ? "in less than 1 $scale" : "less than 1 $scale ago";
            } elseif ($delta == 1) {
                return $future ? "in 1 $scale" : "1 $scale ago";
            } elseif ($delta < $factor) {
                return $future ? "in $delta ${scale}s" : "$delta ${scale}s ago";
            } else {
                $delta = (int)($delta / $factor);
            }
        }

        return "outside of time";
    }

    function render($mode, &$R, &$triples, $value, $hint) {
        if($mode == 'xhtml') {
            if(is_numeric($value)) {
                // convert
                $basis = time();
                $description = $this->relative_time((int)$value, $basis);

                // produce exact date
                $exact = date('c', $value);

                // render
                $R->doc .= '<span class="stratatimetypes-relative" data-time="'.$exact.'">';
                $R->doc .= $R->_xmlEntities($description);
                $R->doc .= '</span>';
            } else {
                $R->doc .= $R->_xmlEntities($value);
            }
            return true;
        }

        return false;
    }

    function normalize($value, $hint) {
        // try and parse the value
        $date = strtotime($value);

        // handle failure in a non-intrusive way
        if($date === false) {
            return $value;
        } else {
            return $date;
        }
    }
        
    function getInfo() {
        return array(
            'desc'=>'Displays time difference relative to the current time. When used as input type, it understands relative times like \'now +7 days\'.',
            'tags'=>array('numeric')
        );
    }
}
