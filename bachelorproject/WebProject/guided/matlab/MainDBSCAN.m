function [ Points ] = MainDBSCAN( data )

    ind = find(data(:,6)>-1);
    data = data(ind,:);

    rating = data(:, 6);
    rating = 1+rating;
    data = data(:,1:5);

    if(!isempty(data))
        [class,type] = dbscan(data, 4, 1, 0.4);
        Points = calculatePoints(data, rating, class);

        [n,m] = size(Points);

        names = {['trackedPointX'] ['trackedPointY'] ['time'] ['type_id'] ['team_id']};

        string = '[';
        for i=1:n
		if i~=1
		    string = strcat(string,', {');
		else
		    string = strcat(string, '{');
		end

		for j=1:m
		    string = strcat(string, '"', names(j), '":"', num2str(Points(i,j)), '"');
	
		    if j~=m
		    string = strcat(string, ',');
		    end
		end
		string = strcat(string , '}');
        end
        string = strcat(string, ']');


        Points = string(1,1);
    else
   	 Points = [];

    end
end 

