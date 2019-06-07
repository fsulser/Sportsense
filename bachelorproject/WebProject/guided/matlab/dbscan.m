 
% -------------------------------------------------------------------------
% Function: [class,type]=dbscan(data,k,Eps)
% -------------------------------------------------------------------------
% Aim: 
% Clustering the data with Density-Based Scan Algorithm with Noise (DBSCAN)
% -------------------------------------------------------------------------
% Input: 
% data - data set (m,n); m-objects, n-variables
% k - number of objects in a neighborhood of an object 
% (minimal number of objects considered as a cluster)
% Eps - neighborhood radius, if not known avoid this parameter or put []
% -------------------------------------------------------------------------
% Output: 
% class - vector specifying assignment of the i-th object to certain 
% cluster (m,1)
% type - vector specifying type of the i-th object 
% (core: 1, border: 0, outlier: -1)
% -------------------------------------------------------------------------
% Edataample of use:
% data=[randn(30,2)*.4;randn(40,2)*.5+ones(40,1)*[4 4]];
% [class,type]=dbscan(data,5,[])
% clusteringfigs('Dbscan',data,[1 2],class,type)
% -------------------------------------------------------------------------
% References:
% [1] M. Ester, H. Kriegel, J. Sander, data. datau, A density-based algorithm for 
% discovering clusters in large spatial databases with noise, proc. 
% 2nd Int. Conf. on Knowledge Discovery and Data Mining, Portland, OR, 1996, 
% p. 226, available from: 
% www.dbs.informatik.uni-muenchen.de/cgi-bin/papers?query=--CO
% [2] M. Daszykowski, B. Walczak, D. L. Massart, Looking for 
% Natural Patterns in Data. Part 1: Density Based Approach, 
% Chemom. Intell. Lab. Syst. 56 (2001) 83-92 
% -------------------------------------------------------------------------
% Written by Michal Daszykowski
% Department of Chemometrics, Institute of Chemistry, 
% The University of Silesia
% December 2004
% http://www.chemometria.us.edu.pl
 
function [class,type]=dbscan(data, k,Eps, Eps1)
 
[m,n]=size(data);
 
data=[[1:m]' data];
[m,n]=size(data);
type=zeros(1,m);
no=1;
touched=zeros(m,1);
 
for i=1:m
    if touched(i)==0;
       ob=data(i,:);
       D=dist(ob(2:n),data(:,2:n));
       ind=find(D<=Eps);
    
       if length(ind)>1
 	  if length(ind)<k+1       
              type(i)=0;
              class(i)=0;
	  end
       end
       if length(ind)==1
          type(i)=-1;
          class(i)=-1;  
          touched(i)=1;
       end
 
       if length(ind)>=k+1; 
          type(i)=1;
          class(ind)=ones(length(ind),1)*max(no);
          
          while ~isempty(ind)
                ob=data(ind(1),:);
                touched(ind(1))=1;
                ind(1)=[];
                D=dist(ob(2:n),data(:,2:n));
                i1=find(D<=Eps1);
     
                if length(i1)>1
                   class(i1)=no;
                   if length(i1)>=k+1;
                      type(ob(1))=1;
                   else
                      type(ob(1))=0;
                   end
 
                   for i=1:length(i1)
                       if touched(i1(i))==0
                          touched(i1(i))=1;
                          ind=[ind i1(i)];   
                          class(i1(i))=no;
                       end                    
                   end
                end
          end
          no=no+1; 
       end
   end
end
 
i1=find(class==0);
class(i1)=-1;
type(i1)=-1;
 
%............................................
function [D]=dist(i,data)
 
% function: [D]=dist(i,data)
%
% Aim: 
% Calculates the Euclidean distances between the i-th object and all objects in data     
%                                   
% Input: 
% i - an object (1,n)
% data - data matridata (m,n); m-objects, n-variables       
%                                                                 
% Output: 
% D - Euclidean distance (m,1)
 
 
 
[m,n]=size(data);
 
a = ones(m,1)*i;
 
b = a-data;
 
D1 = [sqrt(b(:,1).^2 + b(:,2).^2) b(:,3) b(:,4) b(:,5)];
D1(D1(:,3)~=0,3)=1;
D1(D1(:,4)~=0,4)=1;
 
div = [1/20, 2, 1, 1];
 
D1 = abs(D1);
 
D1 = bsxfun(@times, D1, div);
 
D =  sum(D1')/4; % sqrt(sum(D1'.^2))

