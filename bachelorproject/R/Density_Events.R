install.packages("ggplot2")
library("ggplot2", lib.loc="/Library/Frameworks/R.framework/Versions/3.0/Resources/library")
library(scales)


mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)

A <- query("Select e.rating from Event e, Task t WHERE e.TaskId=t.TaskId AND t.CampaignId=1")

medianA <- median(A$rating)
meanA <- mean(A$rating)

m <- data.frame(value = c(meanA), Means=c("Mean A"))

color_foo <- colorRampPalette(c("lightblue", "darkblue"))
colors <- color_foo(3)

ggplot(A,aes(x=rating)) +
  scale_x_continuous(limits=c(min(A$rating)-1, max(A$rating)+1)) +
  geom_vline(data=m, aes(xintercept=value, colour=Means)) +
  geom_density(data = A, aes(x = rating, color=NA, fill='Density'), alpha=0.3) +
  scale_fill_manual(name = "Density", values = c('blue'),labels = c('All Events'))+
  ggtitle("Density events of second test")

ggplot(A, aes(x=rating)) + geom_histogram(binwidth=0.05)


