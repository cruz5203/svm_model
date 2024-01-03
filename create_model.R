library(e1071)
data<-read.csv("C:/Users/88690/Desktop/大數據(R)/小專題/data.csv",header=TRUE)

#將非數值的欄位轉為數值
data$FAVC<-as.numeric(factor(data$FAVC,levels=c("no","yes")))
data$CAEC<-as.numeric(factor(data$CAEC,levels=c("no","Sometimes","Frequently","Always")))
data$SCC<-as.numeric(factor(data$SCC,levels = c("no","yes")))
data$CALC<-as.numeric(factor(data$CALC,levels=c("no","Sometimes","Frequently","Always")))
data$MTRANS<-as.numeric(factor(data$MTRANS),levels=c("Automobile","Bike","Motorbike","Public_Transportation","Walking"))
data$NObeyesdad<-as.numeric(factor(data$NObeyesdad),levels=c("Insufficient_Weight","Normal_Weight","Obesity_Type_I","Obesity_Type_II","Obesity_Type_III","Overweight_Level_I","0Overweight_Level_II"))
data$NObeyesdad <- as.integer(data$NObeyesdad)

#將資料切割為訓練集和測試集
np<-ceiling(0.1*nrow(data))
test.index<-sample(1:nrow(data),np)
data.test<-data[test.index,]
data.train<-data[-test.index,]

tuned <- tune.svm(NObeyesdad~FAVC+FCVC+NCP+CAEC+CH2O+SCC+FAF+TUE+CALC+MTRANS, data = data.train, gamma = 10^(-3:-1), cost = 10^(-1:1)) 
summary(tuned)

model <- svm(NObeyesdad~FAVC+FCVC+NCP+CAEC+CH2O+SCC+FAF+TUE+CALC+MTRANS, data = data.train)

library("neuralnet")
model=neuralnet(NObeyesdad~FAVC+FCVC+NCP+CAEC+CH2O+SCC+FAF+TUE+CALC+MTRANS, data.train, algorithm = 'rprop+', hidden = 10,
                threshold = 0.01, learningrate = 0.01)


model.pred <- predict(model,data.test)
(table.model.test<-table(pred = model.pred, true = data.test[,17]))
correct.model <- sum(diag(table.model.test))/sum(table.model.test)
(correct.model<-correct.model*100)

people<-data.frame(Gender=NA,
                   Age=NA,
                   Height=NA,
                   Weight=NA,
                   family_history_with_overweight=NA,
                   FAVC=1,
                   FCVC=2,
                   NCP=4,
                   CAEC=3,
                   SMOKE=NA,
                   CH2O=2,
                   SCC=1,
                   FAF=1,
                   TUE=1,
                   CALC=2,
                   MTRANS=4,
                   NObeyesdad=NA
)
data.pred<- predict(model, data[1,])
ans <- as.vector(data.pred)

