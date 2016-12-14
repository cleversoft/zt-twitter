<?php
/**
 * @package ZT Twitter module for Joomla! 3.3
 * @author DucNA
 * @copyright (C) 2014- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 **/
//no direct accees
defined('_JEXEC') or die ('resticted aceess');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zt_twitter/assets/css/zt_bootstrap.css');

$jversion = new JVersion;
$doc = JFactory::getDocument();
$current_version = $jversion->getShortVersion();
if (version_compare($current_version, '3.0.0') <= 0){
    $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery-1.11.1.js');
    $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/bootstrap.js');
    $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery.noConflict.js');
    $document->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/fixConflict.js');
    $document->addStyleSheet(JURI::base() . 'modules/mod_zt_twitter/assets/css/zt_twitter2.5.css');



}else {
    $document->addStyleSheet(JURI::base() . 'modules/mod_zt_twitter/assets/css/zt_twitter.css');

}

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
        ?>
        <div id="zt-carousel<?php echo $module->id; ?>" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                foreach ($rows as $key=>$row) {
                    if(count($row->user) > 0) {
                        ?>
                        <li data-target="#zt-carousel<?php echo $module->id; ?>" data-slide-to="<?php echo $key;?>" class="<?php echo ($key==0)?'active':'';?>"></li>
                    <?php
                    }
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
                foreach ($rows as $key=>$row) {
                    if(count($row->user) > 0) {
                        ?>
                        <div class="zt-timeline-item item <?php echo ($key==0)?'active':'';?>">
                            <?php if ($params->get('show_avatar', 1)) { ?>
                                <div class="zt-item-avatar">
                                    <img src="<?php echo $row->user->profile_image_url_https; ?>"/>
                                </div>
                            <?php } ?>

                            <?php if ($params->get('show_date', 1)) { ?>
                                <span class="zt-item-date"><?php echo JHtml::_('date', $row->created_at, 'F j') . ' ('. $row->time .')'; ?></span>
                            <?php } ?>

                            <div class="zt-item-text"><?php echo $row->text; ?></div>
                            <div style="clear: both;height: 10px"></div>

                        </div>
                    <?php } ?>
                <?php } ?>
            </div><!-- end wrapper carousel  -->
            <!-- control bar -->
            <a class="left carousel-control" href="#zt-carousel<?php echo $module->id; ?>" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#zt-carousel<?php echo $module->id; ?>" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>

            <!-- end control bar -->
        </div>
        <!-- end carousel -->
    <?php } ?>

    <?php if ($params->get('follow_me', 1)) { ?>
        <div class="zt-twitter-follow">
            <a href="http://twitter.com/<?php echo $user_timeline; ?>"
               title="<?php echo JText::_('Follow'); ?>"><?php echo JText::_('Follow'); ?></a>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">

    jQuery(document).ready(function(){
        var carousel = jQuery('#zt-carousel<?php echo $module->id; ?>');
        carousel.carousel({
            wrap: true,
            interval: <?php echo $params->get('pause',2000) ; ?>,
            pause: '<?php echo $params->get('autoPauseHover','none'); ?>'
        });
    });
</script>
