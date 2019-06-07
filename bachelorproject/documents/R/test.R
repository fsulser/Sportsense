install.packages("ggplot2")
library("ggplot2", lib.loc="/Library/Frameworks/R.framework/Versions/3.0/Resources/library")
library(scales)


mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)


A <- query("Select rating from Task WHERE CampaignId=2")
B <- query("Select rating from Task WHERE CampaignId=2 AND rating>=-1")


A <- data.frame(x = c(A), Type = c("All ratings"))
B <- data.frame(x = c(B), Type = c("rating >= -1"))

C <- rbind(A,B)

medianA <- median(A$rating)
meanA <- mean(A$rating)

medianB <- median(B$rating)
meanB <- mean(B$rating)

m <- data.frame(value = c(medianA, medianB, meanA, meanB), Type_A=c("Median A", "Median B", "Mean A", "Mean B"))


ggplot(C, aes(x=rating, colour=Type)) + geom_density(aes(group=Type, fill=Type), alpha=0.3) +
  geom_vline(data=m, aes(xintercept=value, colour=Type_A),linetype="dashed")+
  geom_vline(data=m, aes(xintercept=value, colour=Type_A),linetype="dashed")+
  geom_vline(data=m, aes(xintercept=value, colour=Type_A))+
  geom_vline(data=m, aes(xintercept=value, colour=Type_A))+
  ggtitle("Density of pre test") 