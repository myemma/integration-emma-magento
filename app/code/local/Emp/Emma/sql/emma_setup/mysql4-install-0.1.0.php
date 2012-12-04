<?php
$installer = $this;
$installer->startSetup();
$installer->run("DROP TABLE IF EXISTS {$this->getTable('emma_sync')};
CREATE TABLE {$this->getTable('emma_sync')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groups` varchar(9999) DEFAULT NULL,
  `sync_existing` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
INSERT INTO {$this->getTable('emma_sync')}  (
`id` ,
`groups` ,
`sync_existing`
)
VALUES (
'1', NULL , '0'
);
 ");
//demo 
Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 