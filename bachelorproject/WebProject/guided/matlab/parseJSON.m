function [A] = parseJSON(string)
    string = regexprep(string,'"', '');
    string = regexprep(string,'trackedPointX:','');
    string = regexprep(string,'trackedPointY:','');
    string = regexprep(string,'time:','');
    string = regexprep(string,'team_id:','');
    string = regexprep(string,'type_id:','');
    string = regexprep(string,'userRating:','');
    string = regexprep(string,'},{','";"');
    string = regexprep(string,',',' ');
    string = regexprep(string,'{','');
    string = regexprep(string,'}','');
    string = regexprep(string,'\]',';');
    string = regexprep(string,'\[','');
    string = regexprep(string,'"', '');

    n = length(strfind(string,';'));

    A = zeros(n,6);

    k = [0, strfind(string, ';'), size(string,2)];
    for i=2:n+1
        start = k(i-1);
        endstring = k(i);
        substr = string(start+1: endstring-1);
        [m,stringlength] = size(substr);

        l = [0, strfind(substr, ' '), size(substr,2)];
        for j=2:size(l,2)
 
            val = substr(l(j-1)+1: l(j)-1);
            A(i-1,j-1) = str2num(val);

        end
        
    end
end
