install.packages("ggplot2")
library("ggplot2", lib.loc="/Library/Frameworks/R.framework/Versions/3.0/Resources/library")
library(scales)


mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)


A <- query("Select missed, rating from Task WHERE CampaignId=1 ORDER BY missed, rating desc")
A <- query("Select missed, rating from Task WHERE CampaignId=1 AND rating >-1.5 ORDER BY missed, rating desc")

#A <- data.frame(missed=A[,1],rating=floor(A[,2]))

a = dim(A)

A = A[1:a[1]-1,0:2]

ggplot(A, aes(rating, fill=as.factor(missed))) + geom_bar(binwidth=0.5)+
  scale_fill_manual(name = "missed events", values = c('red','blue', 'green', 'yellow'),labels = c('0','1', '2', '3'))+
  geom_vline(xintercept = -1.25)
  
