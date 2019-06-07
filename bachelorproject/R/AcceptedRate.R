mydb = dbConnect(MySQL(), user='root', password='', dbname='SportSense', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)

A <- query("Select rating from Task WHERE CampaignId=1")


A <- data.frame(rating = c(A[,1]), accepted="Accepted")

A$accepted <- ifelse(A$rating>-1.5, "Accepted", "Rejected")


ggplot(A, aes(x = factor(accepted), fill=factor(accepted))) + geom_bar() + scale_x_discrete(name="") +
  scale_fill_manual(name = "", values = c('green','yellow'),labels = c('Accepted', 'Rejected'))
  