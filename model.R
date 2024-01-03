
args = commandArgs(TRUE)

FAVC = as.numeric(args[1])
FCVC = as.numeric(args[2])
NCP = as.numeric(args[3])
CAEC = as.numeric(args[4])
CH2O = as.numeric(args[5])
SCC = as.numeric(args[6])
FAF = as.numeric(args[7])
TUE = as.numeric(args[8])
CALC = as.numeric(args[9])
MTRANS = as.numeric(args[10])

#FAVC = 1
#FCVC = 2
#NCP = 3
#CAEC = 1
#CH2O = 2
#SCC = 1
#FAF = 0
#TUE = 1
#CALC = 1
#MTRANS = 4

library(e1071)
load("C:/xampp/htdocs/R_test/svm-model.RData", .GlobalEnv)
people<-data.frame(
                   FAVC=FAVC,
                   FCVC=FCVC,
                   NCP=NCP,
                   CAEC=CAEC,
                   CH2O=CH2O,
                   SCC=SCC,
                   FAF=FAF,
                   TUE=TUE,
                   CALC=CALC,
                   MTRANS=MTRANS,
                   NObeyesdad=NA
                   )
data.pred<- predict(model, people[,-11])
ans <- as.vector(data.pred)
ans<-as.numeric(ans)
a<-c("Insufficient_Weight","Normal_Weight","Obesity_Type_I","Obesity_Type_II","Obesity_Type_III","Overweight_Level_I","0Overweight_Level_II")
ans<-a[ans]
print(ans)
print(FAVC)
print(FCVC)
print(NCP)
print(CAEC)
print(CH2O)
print(SCC)
print(FAF)
print(TUE)
print(CALC)
print(MTRANS)

dev.off()

