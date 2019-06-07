-- drop database SportSense_without;
create database SportSense_without;
use SportSense_without;

create table Teams (
    TeamId int not null unique auto_increment,
    TeamName varchar(30)
)  ENGINE=INNODB;

create Table VideoInformations (
    videoId int primary key not null auto_increment,
    link varchar(200) not null,
    homeTeam int not null,
    awayTeam int not null,
    homeColor varchar(30),
    awayColor varchar(30),
    sequence int not null,
    sequenceEnd int not null,
    FOREIGN KEY (homeTeam)
        REFERENCES Teams (TeamId),
    FOREIGN KEY (awayTeam)
        REFERENCES Teams (TeamId)
)  ENGINE=INNODB;

create table campaign (
    CampaignId int primary key auto_increment not null,
    VideoId int not null,
    start int not null,
    sequenceLength int not null,
	number int not null,
    finished int not null,

	FOREIGN KEY (VideoId) REFERENCES VideoInformations(videoId)
)  ENGINE=INNODB;

create table Users (
    UID int not null auto_increment primary key,
    microworkersId varchar(300) not null,
    finishedBasic int,
    email varchar(100),
    userRating float not null
)  ENGINE=INNODB;

create table Task (
    TaskId int not null auto_increment primary key,
    UID int,
    CampaignId int not null,
    sequenceStart float,
    token varchar(1000),
    campaign varchar(1000),
    rating float,
    finished int,
    isRated int,
    missed int,
    FOREIGN KEY (UID)
        REFERENCES Users (UID),
    FOREIGN KEY (CampaignId)
        REFERENCES campaign (CampaignId)
)  ENGINE=INNODB;

create table TaskInProgress (
    TaskId int not null,
    started TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Taskid)
        REFERENCES Task (TaskId)
)  ENGINE=INNODB;

create table EventNames (
    EventNamesId int not null primary key,
    ListId int not null,
    EventName varchar(60),
    EventDescription varchar(300)
)  ENGINE=INNODB;

create table Event (
    EventId int not null auto_increment primary key,
    TaskId int not null,
    trackedPointX float,
    trackedPointY float,
    min int,
    sec int,
    msec int,
    type_id int not null,
    team_id int,
    player_id int,
    period_id int,
    rating float,
    FOREIGN KEY (TaskId)
        REFERENCES Task (TaskId),
    FOREIGN KEY (type_id)
        REFERENCES EventNames (EventNamesId)
)  ENGINE=INNODB;

create table CalculatedEvent (
    EventId int not null auto_increment primary key,
    CampaignId int not null,
    trackedPointX float,
    trackedPointY float,
    min int,
    sec int,
    msec int,
    type_id int not null,
    team_id int,
    player_id int,
    period_id int,
    FOREIGN KEY (CampaignId)
        REFERENCES campaign (CampaignId),
    FOREIGN KEY (type_id)
        REFERENCES EventNames (EventNamesId)
)  ENGINE=INNODB;

create table GroundTruth (
    EventId int not null auto_increment primary key,
    trackedPointX float,
    trackedPointY float,
    min int,
    sec int,
    msec int,
    type_id int not null,
    team_id int,
    player_id int,
    period_id int,
    FOREIGN KEY (type_id)
        REFERENCES EventNames (EventNamesId)
)  ENGINE=INNODB;

create Table Admin (
    AdminId int not null unique auto_increment primary key,
    AdminName varchar(60),
    AdminPW varchar(1000)
)  ENGINE=INNODB;



Insert into Admin values(0, 'azureuser', '235a6085e75b0e7c0cdace5f7af2d663723ce6cebfe85108ab94279fd1eb75b682742854c4b1b609a799e57ee091d0e34ddf8cbd208defc5f4c87966db796747');

-- drop table Event;
-- drop table EventNames;
-- drop table Task;
-- drop table Users;
-- drop table VideoInformations

Insert into Teams values (30, 'Bolton Wanderers');
Insert into Teams values (43, 'Manchester City');
Insert into VideoInformations values (0, 'videos/medium.mp4', 30, 43, 'white', 'red', 0, 2829);
-- Insert into VideoInformationsBasic values (0, 'videos/medium.mp4', 30, 43, 'white', 'red', 2330, 5);

Insert into campaign values(0, 1, 2330, 5, 0, 0);
