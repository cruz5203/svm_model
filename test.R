library(rpart)
data<-read.csv("C:/Users/88690/Desktop/大數據(R)/小專題/data.csv",header=TRUE)
process_data<-data
process_data$Gender<-as.numeric(factor(data$Gender,levels=c("Male","Female")))
process_data$family_history_with_overweight<-as.numeric(factor(data$family_history_with_overweight,levels=c("no","yes")))
process_data$FAVC<-as.numeric(factor(data$FAVC,levels=c("no","yes")))
process_data$CAEC<-as.numeric(factor(data$CAEC,levels=c("no","Sometimes","Frequently","Always")))
process_data$SMOKE<-as.numeric(factor(data$SMOKE,levels = c("no","yes")))
process_data$SCC<-as.numeric(factor(data$SCC,levels = c("no","yes")))
process_data$CALC<-as.numeric(factor(data$CALC,levels=c("no","Sometimes","Frequently","Always")))
process_data$MTRANS<-as.numeric(factor(data$MTRANS),levels=c("Automobile","Bike","Motorbike","Public_Transportation","Walking"))
np<-ceiling(0.1*nrow(process_data))
test.index<-sample(1:nrow(process_data),np)
testdata<-process_data[test.index,]
traindata<-process_data[-test.index,]
data.tree=rpart(NObeyesdad~FAVC+FCVC+NCP+CAEC+CH2O+SCC+FAF+TUE+CALC+MTRANS ,method="class",data=traindata)
NObeyesdad.traindata=data$NObeyesdad[-test.index]
train.predict=predict(data.tree, traindata, type="class")
table.trandata=table(NObeyesdad.traindata,train.predict)
correct.traindata =sum(diag(table.trandata))/sum(table.trandata)*100
correct.traindata
NObeyesdad.testdata=data$NObeyesdad[test.index]
test.predict=predict(data.tree, testdata, type="class")
table.testdata=table(NObeyesdad.testdata,test.predict)
correct.testdata =sum(diag(table.testdata))/sum(table.testdata)*100
correct.testdata
save(data.tree,file="C:/xampp/htdocs/R_test/Obesity_or_CVD_risk-rpart.RData")
