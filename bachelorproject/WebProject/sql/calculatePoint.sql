-- Calculate Position for first event (Pass)

Select sum(e.trackedPointX)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=1;
Select sum(e.trackedPointY)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=1;

-- Calculate Position for first event (Shoot on targe)

Select sum(e.trackedPointX)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=15;
Select sum(e.trackedPointY)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=15;

-- Calculate Position for first event (Goal)

Select sum(e.trackedPointX)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=16;
Select sum(e.trackedPointY)/(Count(*)) from Event e where e.rating>-0.5 and e.type_id=16;

-- Calculate distnace between truth and data for each Point
Select abs(b.trackedPointX-sum(e.trackedPointX)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=1;
Select abs(b.trackedPointY-sum(e.trackedPointY)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=1;

Select abs(b.trackedPointX-sum(e.trackedPointX)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=15;
Select abs(b.trackedPointY-sum(e.trackedPointY)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=15;

Select abs(b.trackedPointX-sum(e.trackedPointX)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=16;
Select abs(b.trackedPointY-sum(e.trackedPointY)/(Count(*))) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=16;

-- Calculate the distance
Select sqrt(pow(b.trackedPointX-sum(e.trackedPointX)/(Count(*)),2) + pow(b.trackedPointY-sum(e.trackedPointY)/(Count(*)),2)) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=1;
Select sqrt(pow(b.trackedPointX-sum(e.trackedPointX)/(Count(*)),2) + pow(b.trackedPointY-sum(e.trackedPointY)/(Count(*)),2)) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=15;
Select sqrt(pow(b.trackedPointX-sum(e.trackedPointX)/(Count(*)),2) + pow(b.trackedPointY-sum(e.trackedPointY)/(Count(*)),2)) from Event e LEFT JOIN BasicEvent b ON e.type_id= b.type_id where e.rating>-0.5 and e.type_id=16;



