df <- data.frame( Country = c("Bangladesh", "Nepal", "India", "Romania", "Serbia", "Macedinia", "Sri Lanka", "Bulgaria", "United States", "Pakistan", "indonesia", "Portugal", "United Kingdom", "Italy", "Other"),
                  value = c(701, 191, 123, 80, 71, 56, 53, 51, 49, 47, 30, 24, 20, 18, 183)
)

df <- data.frame( Continent = c("Asia", "Europe", "Americas", "Africa", "Oceania"),
                  value = c(1204, 401, 57, 32, 1)
)



ggplot(data=df, aes(x = "", y = value, fill = Continent)) +
  geom_bar(width = 1, stat = "identity") +
  coord_polar("y", start = 0) +
  labs(title = "Continental distribution") +
  scale_x_discrete(name="") + scale_y_continuous(name="") +
  coord_polar(theta = "y") + labs(y="", x='')
 


df <- data.frame( type = c("Average", "Accepted", "Rejected"),
                  time = c("3:42", "4:34", "1:05")
)


ggplot(df, aes(x = factor(type), y = time, fill=type)) + geom_bar(stat = "identity") + 
  theme(axis.ticks = element_blank(), axis.text.x = element_blank()) + scale_x_discrete(name="")
