/*
// this file is used for both DB changes and vendor changes

--install laravel tagging
	composer require rtconner/laravel-tagging "~2.0"
	php artisan vendor:publish --provider="Conner\Tagging\Providers\TaggingServiceProvider"
  php artisan migrate

-- install Avatar
	composer require laravolt/avatar
	php artisan vendor:publish --provider="Laravolt\Avatar\ServiceProvider"
  php artisan migrate

// Please add your sql changes to the migration files in addition to this file.
// Developer who want to have a fresh database can run the below 2 commands
// might need to run                        >         composer dump-autoload
// drops the table and creates them again   >          php artisan migrate:refresh
// fills with sample data                   >          php artisan db:seed

// Developer who want to keep working with his data will run the below sql commands,
*/
// deleted mark field from question table and added to examquestion
// deleted mediaurl and mediapath from question
// deleted mark field from question table

ALTER TABLE `skillcategories` ADD `duration` INT NOT NULL DEFAULT '0' AFTER `new_sort_order`;

CREATE TABLE `examselections` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `selection_id` int(11) NOT NULL,
  `selection_table` varchar(100) NOT NULL,
  `isselected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `examselections`
  ADD PRIMARY KEY (`id`);



--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `examselections`
--
ALTER TABLE `examselections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;




ALTER TABLE `examquestions`
  DROP `mark`;


  CREATE TABLE `passages` (
    `id` int(11) NOT NULL,
    `passage_title` varchar(250) CHARACTER SET utf8 NOT NULL,
    `passage_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `exercise_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `passages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `exercise_id` (`exercise_id`);


ALTER TABLE `passages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `passages`
  ADD CONSTRAINT `passages_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `exercisesets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

ALTER TABLE `questions` ADD `passage_id` INT NULL DEFAULT NULL AFTER `skill_id`;

ALTER TABLE `questions` ADD INDEX( `passage_id`);

ALTER TABLE `questions` ADD `size` INT NULL DEFAULT NULL AFTER `skillcategory_id`;
// 29-5-2018
ALTER TABLE `userexamanswers` ADD `class_id` INT NOT NULL AFTER `exam_id`;
ALTER TABLE `userexamanswers` ADD `classexam_id` INT NOT NULL AFTER `class_id`;
ALTER TABLE `userexamanswers` CHANGE `attempt_number` `attempt_number` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `userexamscores` ADD `classexam_id` INT NOT NULL AFTER `exam_id`;

ALTER TABLE `classlearners` CHANGE `status` `status` ENUM('Pending','Accepted','Rejected','Invited') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending';
ALTER TABLE `userexamscores` CHANGE `classexam_id` `classexam_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `userexamscores` CHANGE `game_id` `game_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `userexamscores` CHANGE `match_uid` `match_uid` INT(11) NULL DEFAULT NULL;



--- add about me records ----

ALTER TABLE `users` ADD `aboutme` LONGTEXT NULL AFTER `updated_at`;ALTER TABLE `users` ADD `aboutme` LONGTEXT NULL AFTER `updated_at`;




ALTER TABLE `disciplines` ADD `topic_id` INT NOT NULL AFTER `curriculum_gradelist_id`;
drop discipline_id from topics table .
ALTER TABLE `disciplines` ADD `group_id` INT NULL DEFAULT NULL AFTER `topic_id`;
RENAME TABLE `eduplaydata`.`curricula` TO `eduplaydata`.`curricula_gradelists`;
ALTER TABLE `curricula_gradelists` CHANGE `curriculum_name` `curriculum_gradelist_name` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `disciplines` CHANGE `curriculum_gradelist_id` `curriculum_gradelist_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `topics` ADD `iconurl` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `topic_name`;


ALTER TABLE `users` ADD `devicetype` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `mobile`;

ALTER TABLE `userinterests` ADD `language_id` INT NULL DEFAULT NULL AFTER `created_at`,
 ADD `grade_id` INT NULL DEFAULT NULL AFTER `language_id`, ADD `exercise_type` INT NOT NULL DEFAULT '0' AFTER `grade_id`;

ALTER TABLE `userinterests` ADD `topic_id` INT NULL DEFAULT NULL AFTER `discipline_id`;

//---------------------------------------------------------------------- 04-07-2018 ---- create a new table :practiceresults
CREATE TABLE `practiceresults` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `iscorrect` tinyint(1) NOT NULL,
  `topics_id` int(11) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `practiceresults`
--
ALTER TABLE `practiceresults`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `practiceresults`
--
ALTER TABLE `practiceresults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

//---------------------------------------------------------------------- 04-07-2018

 // ------------------------------------------------------------------------------ 11-07-2018
RENAME TABLE skillmasterylevels TO userskillmasterylevels

 // ------------------------------------------------------------------------------ 11-07-2018



 -- Table structure for table `skillmasterylevels` -- 11-07-2018
--

CREATE TABLE `skillmasterylevels` (
  `id` int(11) NOT NULL,
  `levelname` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `level_massage` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `min_score` int(11) NOT NULL DEFAULT '0',
  `max_score` int(11) NOT NULL DEFAULT '0',
  `min_consecutive_value` int(11) NOT NULL DEFAULT '0',
   `max_consecutive_value` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `skillmasterylevels`
--
ALTER TABLE `skillmasterylevels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `skillmasterylevels`
--
ALTER TABLE `skillmasterylevels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `skillmasterylevels` ADD `created_at` TIMESTAMP NOT NULL AFTER `consecutive_value`, ADD `updated_at` TIMESTAMP NOT NULL AFTER `created_at`;

COMMIT;

ALTER TABLE `userskillmasterylevels` ADD `classexam_id` INT NULL DEFAULT NULL AFTER `skill_id`;

 // ------------------------------------------------------------------------------ 11-07-2018
ALTER TABLE `questions` ADD `json_details` TEXT NULL DEFAULT NULL AFTER `details`;


//------------------------14-07-2018   CREATE TABLE `xp_points`--------------------------------------------------------
CREATE TABLE `xp_points` (
  `id` int(11) NOT NULL,
  `activity_name` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `xp_points`
--
ALTER TABLE `xp_points`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--useractivitylogs
-- AUTO_INCREMENT for table `xp_points`
--
--
ALTER TABLE `xp_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
-----------------------------------14-07-2018 ----------------------------------------------------------------------------

ALTER TABLE `useractivitylogs` CHANGE `newpoints` `details` TEXT NULL DEFAULT NULL;

ALTER TABLE `badges` CHANGE `badgeorder` `badgegroup` INT(11) NULL DEFAULT NULL;

------------------------------------14-07-2018----------------------------------------------------------------------------

ALTER TABLE `practiceresults` ADD `user_id` INT NOT NULL AFTER `question_id`;


-------------------------------------18-7-2018---------------------------------------------------------------------------------
ALTER TABLE `xp_points` CHANGE `activity_name` `activity_name` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

--------------------------------------------18-7-2018---------------------------------------------------------------------------

ALTER TABLE `useractivitylogs` ADD `points` INT NOT NULL AFTER `user_id`, ADD `accumulated_points` INT NOT NULL AFTER `points`;

-------------------------------------------------27 - 7 -2018--------------------------------------------------------------------


ALTER TABLE `userexamanswers` ADD `match_uid` INT NOT NULL DEFAULT '0' AFTER `gameid`, ADD `match_datetime` DATETIME NOT NULL AFTER `match_uid`;

-----------------------------------------------------------------------------------------------------------------------------------
ALTER TABLE `useractivitylogs` CHANGE `activity_id` `activity_id` INT(11) NULL;

ALTER TABLE `questions` ADD `mintime` INT(4) NOT NULL DEFAULT '0' AFTER `maxtime`;


ALTER TABLE `userexamanswers` ADD `params` INT(2) NOT NULL DEFAULT '0' AFTER `match_datetime`;
