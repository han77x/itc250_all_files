/*
  surveysez-02062018.sql
  
  Here are a few notes on things below that may not be self evident:
  
  INDEXES: You'll see indexes below for example:
  
  INDEX SurveyID_index(SurveyID)
  
  Any field that has highly unique data that is either searched on or used as a join should be indexed, which speeds up a  
  search on a tall table, but potentially slows down an add or delete
  
  TIMESTAMP: MySQL currently only supports one date field per table to be automatically updated with the current time.  We'll use a 
  field in a few of the tables named LastUpdated:
  
  LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP
  
  The other date oriented field we are interested in, DateAdded we'll do by hand on insert with the MySQL function NOW().
  
  CASCADES: In order to avoid orphaned records in deletion of a Survey, we'll want to get rid of the associated Q & A, etc. 
  We therefore want a 'cascading delete' in which the deletion of a Survey activates a 'cascade' of deletions in an 
  associated table.  Here's what the syntax looks like:  
  
  FOREIGN KEY (SurveyID) REFERENCES wn18_surveys(SurveyID) ON DELETE CASCADE
  
  The above is from the Questions table, which stores a foreign key, SurveyID in it.  This line of code tags the foreign key to 
  identify which associated records to delete.
  
  Be sure to check your cascades by deleting a survey and watch all the related table data disappear!
  
  $sql = 
"
select CONCAT(a.FirstName, ' ', a.LastName) AdminName, s.SurveyID, s.Title, s.Description, 
date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from "
. PREFIX . "surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc
";
  
  
*/


SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS wn18_responses_answers; 
DROP TABLE IF EXISTS wn18_responses;
DROP TABLE IF EXISTS wn18_answers;
DROP TABLE IF EXISTS wn18_questions;
DROP TABLE IF EXISTS wn18_surveys;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE wn18_surveys(
SurveyID INT UNSIGNED NOT NULL AUTO_INCREMENT,
AdminID INT UNSIGNED DEFAULT 0,
Title VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
TimesViewed INT DEFAULT 0,
Status INT DEFAULT 0,
PRIMARY KEY (SurveyID)
)ENGINE=INNODB; 

#assigning first survey to AdminID == 1
INSERT INTO wn18_surveys VALUES (NULL,1,'Our First Survey','Description of Survey',NOW(),NOW(),0,0);

/*--- SQL For A5survey Homewrk START---*/ 
INSERT INTO wn18_surveys VALUES (NULL,2,'Our Second Survey','PC or Mac',NOW(),NOW(),0,0); 
INSERT INTO wn18_surveys VALUES (NULL,3,'Our Third Survey','Health',NOW(),NOW(),0,0); 
INSERT INTO wn18_surveys VALUES (NULL,4,'Our Fourth Survey','Marvel vs DC',NOW(),NOW(),0,0); 
/*--- SQL For A5survey Homewrk END---*/ 

#foreign key field must match size and type, hence SurveyID is INT UNSIGNED
CREATE TABLE wn18_questions(
QuestionID INT UNSIGNED NOT NULL AUTO_INCREMENT,
SurveyID INT UNSIGNED DEFAULT 0,
Question TEXT DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (QuestionID),
INDEX SurveyID_index(SurveyID),
FOREIGN KEY (SurveyID) REFERENCES wn18_surveys(SurveyID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO wn18_questions VALUES (NULL,1,'Do You Like Our Website?','We really want to know!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,1,'Do You Like Cookies?','We like cookies!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,1,'Favorite Toppings?','We like chocolate!',NOW(),NOW());

/*--- SQL For A5survey Homewrk START---*/ 

INSERT INTO wn18_questions VALUES (NULL,2,'Do you like PC or Mac?','PC rules!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,2,'How many hrs do you spend on the computer?','We like tech!',NOW(),NOW());

INSERT INTO wn18_questions VALUES (NULL,3,'Do You Excercise Every Day?','Cardio is Good!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,3,'Do You eat healthy?','McDonalds is not Healthy!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,4,'Who is Better Marvel or DC?','In your opinion!',NOW(),NOW());
INSERT INTO wn18_questions VALUES (NULL,4,'Who would win if Spiderman fought Batman?','Batman!',NOW(),NOW());
/*--- SQL For A5survey Homewrk END---*/ 

CREATE TABLE wn18_answers(
AnswerID INT UNSIGNED NOT NULL AUTO_INCREMENT,
QuestionID INT UNSIGNED DEFAULT 0,
Answer TEXT DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
Status INT DEFAULT 0,
PRIMARY KEY (AnswerID),
INDEX QuestionID_index(QuestionID),
FOREIGN KEY (QuestionID) REFERENCES wn18_questions(QuestionID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO wn18_answers VALUES (NULL,1,'Yes','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,1,'No','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,2,'Yes','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,2,'No','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,2,'Maybe','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,3,'Chocolate','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,3,'Butterscotch','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,3,'Pineapple','',NOW(),NOW(),0);

/*--- SQL For A5survey Homewrk START---*/ 
INSERT INTO wn18_answers VALUES
(NULL,4,'PC','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,4,'MAC','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,5,'More than 5 hrs','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,5,'Less than 5 hrs','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,6,'Yes','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,6,'No','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,7,'Yes','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,7,'No','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,8,'Marvel','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,8,'DC','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,9,'Spiderman','',NOW(),NOW(),0);
INSERT INTO wn18_answers VALUES (NULL,9,'Batman','',NOW(),NOW(),0);
/*--- SQL for A5survey Homewrk END---*/

CREATE TABLE wn18_responses(
ResponseID INT UNSIGNED NOT NULL AUTO_INCREMENT,
SurveyID INT UNSIGNED NOT NULL DEFAULT 0,
DateAdded DATETIME,
PRIMARY KEY (ResponseID),
INDEX SurveyID_index(SurveyID),
FOREIGN KEY (SurveyID) REFERENCES wn18_surveys(SurveyID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO wn18_responses VALUES (NULL,1,NOW());

/*--- SQL For A5survey Homewrk START---*/ 
INSERT INTO wn18_responses VALUES (NULL,2,NOW());
INSERT INTO wn18_responses VALUES (NULL,3,NOW());
INSERT INTO wn18_responses VALUES (NULL,4,NOW());
/*--- SQL For A5survey Homewrk END---*/ 

CREATE TABLE wn18_responses_answers(
RQID INT UNSIGNED NOT NULL AUTO_INCREMENT,
ResponseID INT UNSIGNED DEFAULT 0,
QuestionID INT DEFAULT 0,
AnswerID INT DEFAULT 0,
PRIMARY KEY (RQID),
INDEX ResponseID_index(ResponseID),
FOREIGN KEY (ResponseID) REFERENCES wn18_responses(ResponseID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO wn18_responses_answers VALUES (NULL,1,1,1);
INSERT INTO wn18_responses_answers VALUES (NULL,1,2,5);
INSERT INTO wn18_responses_answers VALUES (NULL,1,3,6);
INSERT INTO wn18_responses_answers VALUES (NULL,1,3,7);
INSERT INTO wn18_responses_answers VALUES (NULL,1,3,8);

/*--- SQL For A5survey Homewrk START---*/ 
INSERT INTO wn18_responses_answers VALUES (NULL,2,4,9);
INSERT INTO wn18_responses_answers VALUES (NULL,2,4,10);
INSERT INTO wn18_responses_answers VALUES (NULL,2,5,11);
INSERT INTO wn18_responses_answers VALUES (NULL,2,5,12);
INSERT INTO wn18_responses_answers VALUES (NULL,3,6,13);
INSERT INTO wn18_responses_answers VALUES (NULL,3,6,14);
INSERT INTO wn18_responses_answers VALUES (NULL,3,7,15);
INSERT INTO wn18_responses_answers VALUES (NULL,3,7,16);
INSERT INTO wn18_responses_answers VALUES (NULL,4,8,17);
INSERT INTO wn18_responses_answers VALUES (NULL,4,8,18);
INSERT INTO wn18_responses_answers VALUES (NULL,4,9,19);
INSERT INTO wn18_responses_answers VALUES (NULL,4,9,20);

/*--- SQL For A5survey Homewrk END---*/ 
SET foreign_key_checks = 1; #turn foreign key check back on
