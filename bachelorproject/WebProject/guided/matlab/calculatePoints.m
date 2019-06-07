function [ Points ] = calculatePoints( data, rating, class )
    ind = find(class~=-1);
    class = class(ind);
    data = data(ind,:);
    [n,m] = size(data);

    
    maximum = max(class);
    
    Points = zeros(maximum, m);
    
    for i=1:maximum
        ind = find(class==i)
	    if(length(ind)>=4)
		    Points(i,1:3) = sum(bsxfun(@times, data(ind,1:3), rating(ind)))/sum(rating(ind));
		    Points(i,4) = mode(data(ind,4));
		    Points(i,5) = mode(data(ind,5));

		    data(ind,4);
	     end
    end

    Points(all(Points==0, 2), :)=[];
    
end
