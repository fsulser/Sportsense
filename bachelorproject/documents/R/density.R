install.packages("ggplot2")
library("ggplot2", lib.loc="/Library/Frameworks/R.framework/Versions/3.0/Resources/library")
library(scales)


mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)


A <- query("Select rating from Task WHERE CampaignId=3 ORDER BY rating DESC")
B <- query("Select rating from Task WHERE CampaignId=1 AND rating>-1.5")
D <- query("Select rating from Task WHERE CampaignId=1 AND rating>=-1")



A <- data.frame(rating = c(A[1:a[1]-1,0:1]))

ggplot(A, aes(x=rating)) + geom_histogram(binwidth=0.5, fill = "red", color="black") + geom_vline(xintercept=0.25, color="blue")+
  scale_x_continuous(limits = c(-3, 3))


A <- data.frame(x = c(A), Type = c("A"))
B <- data.frame(x = c(B), Type = c("B"))
D <- data.frame(x = c(D), Type = c("C"))

C <- rbind(A,B, D)

medianA <- median(A$rating)
meanA <- mean(A$rating)

medianB <- median(B$rating)
meanB <- mean(B$rating)

medianC <- median(D$rating)
meanC <- mean(D$rating)

m <- data.frame(value = c(medianA, medianB, medianC, meanA, meanB, meanC), Means=c("Median A", "Median B", "Median C", "Mean A", "Mean B", "Mean C"))
m <- data.frame(value = c(meanA, meanB, meanC), Means=c("Mean A", "Mean B", "Mean C"))

color_foo <- colorRampPalette(c("lightblue", "darkblue"))
colors <- color_foo(3)
  
ggplot(C,aes(x=rating)) +
  scale_x_continuous(limits=c(min(C$rating)-1, max(C$rating)+1)) +
  geom_vline(data=m, aes(xintercept=value, colour=Means)) +
  geom_density(data = A, aes(x = rating, color=NA, fill='A'), alpha=0.3) +
  geom_density(data = B, aes(x = rating, fill='B'), alpha=0.3) +
  geom_density(data = D, aes(x = rating, fill='C'), alpha=0.3) +
  scale_fill_manual(name = "Density", values = c('red','blue', 'green'),labels = c('A','B', 'C'))+
  ggtitle("Density of third test")
  

