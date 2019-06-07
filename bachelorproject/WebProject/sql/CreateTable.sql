-- drop database SportSense1;
create database SportSense1;
use SportSense1;
create Table VideoInformations(
    videoId int primary key not null auto_increment,
    link varchar(200) not null,
    homeTeam varchar(30) not null,
    awayTeam varchar(30) not null,
	homeColor varchar(30),
	awayColor varchar(30),
    sequence int not null,
    sequenceLength int not null,
	sequenceEnd int not null,
	active int
);

create table Users(
    UID int not null auto_increment primary key,
    userEmail varchar(60) not null unique,
    userPassword varchar(1000) not null,
    userRating float not null
);

create table Task(
    TaskId int not null auto_increment primary key,
    UID int not null,
    VideoId int not null,
    sequenceStart int,
    token varchar(1000) not null,
    taskToken varchar(1000),
    rating float,
    finished int,
    isRated int,
    FOREIGN KEY (UID) REFERENCES Users(UID),
    FOREIGN KEY (VideoId) REFERENCES VideoInformations(videoId)
);

create table EventNames(
	EventNamesId int not null primary key,
	ListId int not null,
	EventName varchar(60),
	EventDescription varchar(300)
);

create table Event(
    EventId int not null auto_increment primary key,
    TaskId int not null,
	trackedPoint blob,
	min int,
	sec int,
	type_id int not null,
	team_id int,
	player_id int,
	period_id int,
	rating float,
    FOREIGN KEY (TaskId) REFERENCES Task(TaskId),
	FOREIGN KEY (type_id) REFERENCES EventNames(EventNamesId)
);

-- drop table Event;
-- drop table EventNames;
-- drop table Task;
-- drop table Users;
-- drop table VideoInformations

-- Insert into VideoInformations values (0, '../videos/medium.mp4', 'Bolton Wanderers', 'Manchester City', 'white', 'red', 2000, 5, 2060, 1)

