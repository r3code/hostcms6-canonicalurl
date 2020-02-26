<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Core_CanonicalURL генератор строки canonical-url
 *
 * @package HostCMS 6\Core\CanonicalURL
 * @version 1.0.0
 * @author Dimitriy S. Sinyavskiy (http://r3code.ru)
 * @copyright 2020
 * @compatibility HostCMS 6.1.4+
 */
class Core_CanonicalURL
{

	/**
	 * Core_CanonicalURL::generate() - возвращает canonical-url согласно указанному в настройках элемента пути с сохранением регистра символов
	 *
	 * @return string 
	 *
	 * @example:
	 * <?php echo Core_CanonicalURL::generate(); ?>"
	 *
	 */
	static public function generate()
	{
        $corePage = Core_Page::instance();
        if (is_object($corePage->object))
        {     
            return self::getItemURL();   
        }
        
        $oStructureEntity = $corePage->structure;
        if ($oStructureEntity)
        {            
            return  self::getStructureURL();   
        }
		
		// вернем результат для иных случаев
		return self::getSiteBaseURL(); ;
    }
    
    /**
	 * self::getStructureURL() 
	 *
	 * @return string
	 *
	 */
    static private function getStructureURL() 
    {     
        $corePage = Core_Page::instance();
        $oStructureEntity = $corePage->structure;       
        return self::getSiteBaseURL() . $oStructureEntity->getPath(); // допишем к базовому URL путь структуры        
    }

    /**
	 * self::getItemURL() 
	 *
	 * @return string
	 *
	 */
    static private function getItemURL() 
    {        
        $corePage = Core_Page::instance();
        $oStructureEntity = $corePage->structure;         
        $structureURL = $oStructureEntity->getPath();             
        $url = self::getSiteBaseURL() . $structureURL;  

        $isInformationItem = $corePage->object instanceof Informationsystem_Controller_Show;
        $isShopItem = $corePage->object instanceof Shop_Controller_Show;
    
        if ( $isInformationItem || $isShopItem )
        {           
            $oItem = $corePage->object->item;     
            if ($oItem)
            {                
                $oItemEntity = $isInformationItem
                    ? Core_Entity::factory('Informationsystem_Item', $oItem)
                    : Core_Entity::factory('Shop_Item', $oItem);
                
                return $url . $oItemEntity->getPath();            
            }

            $oGroup = $corePage->object->group;
            if ($oGroup)
            {                      
                $oGroupEntity = $isInformationItem
                    ? Core_Entity::factory('Informationsystem_Group', $oGroup)
                    : Core_Entity::factory('Shop_Group', $oGroup);

                return $url . $oGroupEntity->getPath();            
            }
        }
        return $url;
    }

  
    /**
	 * self::getsiteBaseURL() - получить базовый URL сайта (http://sitename или https://sitename)
	 *
	 * @return string - имя сайта с протоколом или ""
	 *
	 */
    static private function getSiteBaseURL() {
        $protocol = Core::httpsUses() ? 'https://' : 'http://';
        $siteBaseURL = '';
        $oSite = Core_Entity::factory('Site', CURRENT_SITE);
        $oSite_Alias = $oSite->getCurrentAlias();
        if (!$oSite_Alias)
        {
            throw new \Exception('Can not read Site current alias');
        }
        $siteBaseURL = $protocol . $oSite_Alias->name;

        return $siteBaseURL;
    }
}