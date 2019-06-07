-- insert values for events
Insert into EventNames values(1, 0, 'Pass', 'When the player in possession kicks the ball to a teammate');
-- Insert into EventNames values(2, 1, 'Pass - Offside', 'A player is in an offside position if: - Be in the opposition half. <br> - Be in front of the ball. <br> - Have fewer than two opposition players between himself and the goal line when the ball is played to him by a teammate. The goalkeeper can count as an opposing player in this instance.');
-- Insert into EventNames values(3, 4, 'Take on', '');
Insert into EventNames values(4, 12, 'Foul', 'A foul is an unfair act by a player which is deemed by the referee');
Insert into EventNames values(5, 14, 'Out', 'The ball is out if he goes over the outside line with his full volume');
Insert into EventNames values(6, 15, 'Corner Kick', 'A corner cick is when the game is restartet from a corner of the outer field by foot');
Insert into EventNames values(7, 11, 'Tackle', 'When a player without the ball dispossesses an opponent with it.');
Insert into EventNames values(8, 5, 'Interception', 'Intercepting the ball is winning possession of the ball as it is being passed from one opposition player to another.');
-- Insert into EventNames values(12, 9, 'Clearance', 'When a defending player clears the ball out of danger');
Insert into EventNames values(13, 6, 'Shot off target', 'A player shoots and the ball misses the target');
-- Insert into EventNames values(14, 10, 'Post', 'The post that is between the goalkeeper and the attacking player. It is the post closest to the ball.');
Insert into EventNames values(15, 7, 'Shot on target', 'A player shoots and the ball has the direction of the target');
Insert into EventNames values(16, 8, 'Goal', 'A goal is scored when the entire ball crosses the whole of the goal line between the goalposts and the crossbar');
Insert into EventNames values(17, 13, 'Card', 'A player is shown a card by the referee. This can be a yellow or a red one.');
-- Insert into EventNames values(49, 2, 'Pass - Ball recovery', 'A pass wich is recovered by the other team');
-- Insert into EventNames values(61, 3, 'Pass - Ball touch', 'A one touch pass???');


Insert into GroundTruth values(1,637.58,55.46,38,52,2,1,30,NULL,NULL);
Insert into GroundTruth values(2,606.42,182.29,38,53,2,15,30,NULL,NULL);
Insert into GroundTruth values(3,663.76,243.22,38,53,7,16,30,NULL,NULL);
