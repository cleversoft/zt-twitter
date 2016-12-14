<?php
/**
 * @package ZT Twitter module for Joomla! 2.5
 * @author Hiepvu
 * @copyright (C) 2011- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 **/
//no direct accees
defined('_JEXEC') or die ('resticted aceess');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zt_twitter/assets/css/zt_twitter.css');
$user_timeline = $params->get('usernames');
?>
<div id="zt-twitter-timeline<?php echo $module->id; ?>" class="zt-twitter-timeline">
    <?php if ($params->get('show_tweet_title', 1)) { ?>
        <div class="zt-twitter-head">
            <h2><?php echo $params->get('tweet_title_text', 'Tweets'); ?></h2>
        </div>
    <?php } ?>

    <?php
    if(count($rows) > 0) {
        foreach ($rows as $row) {
            if(count($row->user) > 0) {
                ?>
                <div class="zt-timeline-item">
                    <?php if ($params->get('show_avatar', 1)) { ?>
                        <div class="zt-item-avatar">
                            <img src="<?php echo $row->user->profile_image_url_https; ?>"/>
                        </div>
                    <?php } ?>

                    <?php if ($params->get('show_date', 1)) { ?>
                        <span class="zt-item-date"><?php echo JHtml::_('date', $row->created_at, 'F j') . ' ('. $row->time .')'; ?></span>
                    <?php } ?>

                    <div class="zt-item-text"><?php echo $row->text; ?></div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php if ($params->get('follow_me', 1)) { ?>
        <div class="zt-twitter-follow">
            <a href="http://twitter.com/<?php echo $user_timeline; ?>"
               title="<?php echo JText::_('Follow'); ?>"><?php echo JText::_('Follow'); ?></a>
        </div>
    <?php } ?>
</div>