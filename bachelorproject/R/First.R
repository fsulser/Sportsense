

mydb = dbConnect(MySQL(), user='root', password='', dbname='first', host='127.0.0.1')
query = function(...) dbGetQuery(mydb, ...)

A <- query("Select sequenceStart as time from Task where finished=1")



B <- matrix(0:333, ncol=2)


i=0

while(i<=2748-2581){
  j = 0
  c = 0
  while(j<5){
    if(any(A==2581 +i+j)){
      c = c +1
    }
    j = j + 1
    B[i,2] = c
    B[i,1] = i
  }
  i = i +1
  c
}

B <- data.frame(time = c(B[,1]), finished=(B[,2]))

qplot(factor(time), data=B, geom="bar", weight=finished, ylab="number of finished tasks", xlab ="time", fill= finished) +
  theme(axis.ticks = element_blank(), axis.text.x = element_blank())







A <- query("Select e.* from Event e, Task t where e.TaskId= t.TaskId And t.finished=1")
