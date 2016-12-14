<?php
/**
 * @package ZT Twitter module for Joomla! 2.5 vs Joomla 3.0
 * @author Hiepvu
 * @copyright (C) 2013 - ZooTemplate.Com
 * @license PHP files are GNU/GPL
 **/
//no direct accees
defined('_JEXEC') or die ('resticted aceess');
jimport('joomla.filesystem.folder');

require_once(dirname(__FILE__) . DS . 'libs' . DS . 'twitteroauth' . DS . 'twitteroauth.php');

class modZTTwitterHelper
{
    private $params = null;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getList() {
        $cache_time = $this->params->get('cache_time', 3600);
        if($this->params->get('cache', 1) == 1  &&  $cache_time > 0) {
            $cache_file = JPATH_BASE.'/cache/zt_twitter_'.md5('zt_twitter_module');
            if(JFile::exists($cache_file) && (filemtime($cache_file) + $cache_time) > time() ) {
                return json_decode(JFile::read($cache_file));
            } else {
                $twitters = $this->_getList();
                if (JFolder::exists(JPATH_BASE.'/cache/')) {
                    $buffer = json_encode($twitters);
                    JFile::write($cache_file, $buffer);
                }
                return $twitters;
            }
        }else {
            return $this->_getList();
        }
    }


    public function _getList() {
        $consumer_key = base64_decode($this->params->get('consumer_key'));
        $consumer_secret = base64_decode($this->params->get('consumer_secret'));
        $oauth_access_token = base64_decode($this->params->get('oauth_access_token'));
        $oauth_access_token_secret = base64_decode($this->params->get('oauth_access_token_secret'));

        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);

        $rows = $twitter->get(
            'statuses/user_timeline',
            array(
                'screen_name' => trim($this->params->get('usernames', 'zootemplates')),
                'count' => trim($this->params->get('count_twitters', 5)),
            )
        );

        $twitters = array();

        if(!isset($rows->errors)) {
            foreach ($rows as $row) {
                $obj = new stdClass();
                $obj->text = isset($row->text) ? $this->autoLink($row->text) : '';
                $obj->time = isset($row->created_at) ? $this->formatTime($row->created_at) : '';
                $obj->created_at = isset($row->created_at) ?  $row->created_at : '';
                $obj->user = isset($row->user) ? $row->user : '';
                array_push($twitters, $obj);
            }
        }
        return $twitters;
    }

    /**
     * Render hastag, link
     * @param $text
     * @return string
     */
    public function autoLink($text)
    {

        $link = preg_replace('/(https?:\/\/[^\s"<>]+)/', '<a href="$1" target="_blank">$1</a>', $text);
        $link = preg_replace('/(^|[\n\s])@([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/$2" target="_blank">@$2</a>', $link);
        $link = preg_replace('/(^|[\n\s])#([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/search?q=%23$2" target="_blank">#$2</a>', $link);

        return html_entity_decode($link);

    }

    /**
     * Time Ago
     * @param $time
     * @return mixed|string
     */

    function formatTime($time)
    {
        $etime = time() - strtotime($time);

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }

}

?>
