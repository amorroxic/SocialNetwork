
CREATE TABLE `user_photos` (
  `id` mediumint(9) NOT NULL auto_increment,
  `thumb` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `photo` varchar(255) default NULL,
  `description` mediumblob,
  `additional_fields` mediumblob,
  `user_id` mediumint(9) default NULL,
  `photo_category` mediumint(9) default NULL,
  `photo_views` mediumint(9) NOT NULL default '0',
  `photo_rank` float NOT NULL default '1',
  `photo_votes` mediumint(9) NOT NULL default '0',
  `published` date default NULL,
  `photo_id` varchar(255) default NULL,
  `approved` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;
