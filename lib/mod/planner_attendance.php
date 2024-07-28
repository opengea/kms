CREATE TABLE  `ashtangayogamadrid`.`kms_planner_attendance` (
  `id` int(11) NOT NULL auto_increment,
  `dr_folder` varchar(100) NOT NULL default '',
  `creation_date` datetime NOT NULL,
  `status` varchar(100) NOT NULL default '',
  `sr_family` varchar(100) NOT NULL default '',
  `sr_client` varchar(100) NOT NULL default '',
  `userid` varchar(50) NOT NULL,
  `comments` text NOT NULL,
   `labels` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
