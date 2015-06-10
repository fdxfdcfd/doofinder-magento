<?php
class Doofinder_Feed_Block_Settings_Panel_Message extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Error prefix
     * @var stirng
     */
    const ERROR_PREFIX = "#error#";

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $name = $element->getName();
        $element->setScopeLabel('');
        $code = Mage::getSingleton('adminhtml/config_data')->getStore();
        $field = $this->_getField($name);
        $html = '';
        if ($field && $code) {
            $msg = Mage::getModel('doofinder_feed/cron')->load($code, 'store_code')->getData($field);
            $class = 'feed-message ';

            // Mark message as an error
            if (strpos($msg, self::ERROR_PREFIX) !== false) {
                $msg = str_replace(self::ERROR_PREFIX, '', $msg);
                $class .= 'error';
            }

            $html = "<p class='{$class}'>{$msg}</p>";
        }
        return $html;
    }

    private function _getField($name = null) {

        $pattern = '/groups\[panel\]\[fields\]\[([a-z_-]*)\]\[value\]/';
        $preg = preg_match($pattern, $name, $match);
        if ($preg && isset($match[1])) {
            return $match[1];
        } else {
            return false;
        }
    }
}
