mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)


# getting the data for the ground truth test

A <- query("Select UID, rating from Task WHERE CampaignId=1")
dens <- density(as.numeric(A$rating))

median <- median(A$rating)
mean <- mean(A$rating)

plot(dens) + abline(0,100)
#plot(dens, main="Density of pre test")
plot (dens, xlab="Year",ylab="Expen

lines(mean,0,col="red",lwd=2.5) # adds a line for defense expenditures 

lines(median,0,col="blue",lwd=2.5) # adds a line for health expenditures 

legend(2000,9.5, # places a legend at the appropriate place 
       c("Health","Defense"), # puts text in the legend 
       
       lty=c(1,1), # gives the legend appropriate symbols (lines)
       
       lwd=c(2.5,2.5),col=c("blue","red")) # gives the legend lines the correct color and width