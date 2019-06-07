

mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)


A <- query("Select rating from Task WHERE CampaignId=1")
B <- query("Select rating from Task WHERE CampaignId=1 AND rating>=-1.5")
D <- query("Select rating from Task WHERE CampaignId=1 AND rating>=-1")


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

m <- data.frame(value = c(medianA, medianB, medianC, meanA, meanB, meanC), Type_A=c("Median A", "Median B", "Median C", "Mean A", "Mean B", "Mean C"))
m <- data.frame(value = c(meanA, meanB, meanC), Type_A=c("Mean A", "Mean B", "Mean C"))

ggplot(C, aes(x=Type, y=rating)) +
  geom_boxplot(aes(fill = Type))
