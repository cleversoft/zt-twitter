<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField {
    protected $type = 'Asset';
    protected function getInput() {
        $jversion = new JVersion;
        $doc = JFactory::getDocument();
        $current_version = $jversion->getShortVersion();
        if (version_compare($current_version, '3.0.0') <= 0){
            $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery-1.11.1.js');
            $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery.noConflict.js');
            $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery.base64.js');
            $doc->addScript(JURI::root().$this->element['path'].'js/script2.5.js');

        }else {
            JHtml::_('jquery.framework');
            $doc->addScript(JURI::root().'modules/mod_zt_twitter/admin/js/jquery.base64.js');
            $doc->addScript(JURI::root().$this->element['path'].'js/script3x.js');

        }


        return null;
    }
}
