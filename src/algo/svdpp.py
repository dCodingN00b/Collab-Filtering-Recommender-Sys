from surprise import accuracy, Dataset, Reader, SVDpp
from surprise.model_selection import GridSearchCV, cross_validate, train_test_split
from collections import defaultdict
# import pandas, numpy, matplotlib, seaborn libraries
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import time

def rename_ID(x):
    if len(x)>10:
        return "userID"
    if len(x)==10:
        return "prodID"
    if x=='5.0' or x=='4.0' or x=='3.0' or x=='2.0' or x=='1.0':
        return "rating"
    return x

def start():
    #read in data from .csv file
    df = pd.read_csv("ratings_Electronics (1).csv")
    
    # RandomState(0) to ensure that the result yield the same results
    rng = np.random.RandomState(0)
    
    print("is any of the variables null values?\n", df.isnull().sum())
    
    #use rename for renaming of dataframe with the function rename_ID
    if (df.columns[0]!='userID' and df.columns[1]!='prodID' and df.columns[2]!='rating'):
        df = df.rename(columns=rename_ID)
    
    # copying only column 0 to 3.
    # Have to do this way, due to duplicates of length statement.
    df_shape = df.shape
    
    # only slice the df if there is more than 3 columns in the dataset
    if (df_shape[1]>3):
        df = df.iloc[:,0:3].copy()
    
    # check for number of rows of data
    # sample 10k from the original df
    if (df_shape[0]>10000):
        df = df.sample(10000, random_state=rng)
    # else if sample at 1k
    elif (df_shape[0]>1000):
        df = df.sample(1000, random_state=rng)
    
    # display dataframe info
    df.info()
    
    #plt.figure(figsize=(10,6))
    #sns.countplot(x='rating', data=df)
    #plt.xlabel('Rating', fontsize=13)
    #plt.ylabel('Count', fontsize=13)
    #plt.title('Number of Each Rating', fontsize=16)
    #plt.show()
    
    print("\nspread of ratings after sample of 10k")
    print("ratings 1: ", len(df[df.rating==1]))
    print("ratings 2: ", len(df[df.rating==2]))
    print("ratings 3: ", len(df[df.rating==3]))
    print("ratings 4: ", len(df[df.rating==4]))
    print("ratings 5: ", len(df[df.rating==5]))
    
    # reader to read data
    reader = Reader()
    
    #svd++ algo
    print ("\n================== svdpp algo ==================\n")
    svdppcv3_gs(df, reader, rng)
    

def svdppcv3_gs(df, reader, rng):    
    print("put dataset of 'userID', 'prodID', 'rating' parameters to load into df")
    
    # finding time taken for code to run
    start_time = time.time()
    
    data = Dataset.load_from_df(df[['userID', 'prodID', 'rating']], reader) #
    
    # hyperparameters # "n_factors": [10, 20, 30], doesn't change with 10 and 30
    # maybe tweak this init_std_dev: [0.05, 0.1, 0.15] # default 0.1
    param_grid = {"n_epochs": [40, 50, 65],
                  "lr_all": [0.002, 0.005], 
                  "reg_all": [0.04, 0.06, 0.07]} #
    
    print ("running GridSearchCV with cv=3 and n_jobs=-1 which will enable all cpu cores")
    
    gs_cv3 = GridSearchCV(SVDpp, param_grid, measures=["rmse", "mae"], cv=3, n_jobs=-1)
    
    gs_cv3.fit(data)
    
    # best RMSE score
    print("Best GS cv=3 RMSE: ", gs_cv3.best_score["rmse"])
    
    # combination of parameters that gave the best RMSE score
    print("\nBest parameters obtained by gridsearchCV:", gs_cv3.best_params["rmse"])
    
    # to put the best values into the svd algo
    svd_pp_cv3 = gs_cv3.best_estimator["rmse"]
    
    # build trainset from data
    train_set = data.build_full_trainset()
    
    # build testset from trainset
    data_testset = train_set.build_testset()
    
    # fit trainset
    svd_pp_cv3.fit(train_set)
    
    # trainset on testset
    bestpred_cv3 = svd_pp_cv3.test(data_testset)
    
    # Then compute RMSE
    rmseVal = accuracy.rmse(bestpred_cv3, verbose=False)
    
    print("\nRMSE for trainset on testset:", round(rmseVal, 4))
    
    # make predictions
    print ("\n=============== Rating Prediction ===============")
    
    pred_cv3 = svd_pp_cv3.predict(uid='A17HMM1M7T9PJ1', iid='0970407998', r_ui=None).est
    
    print ("rating prediction for A17HMM1M7T9PJ1 on prodID = 0970407998: ", round(pred_cv3))
    
    print ("\nrandom prediction 1:")
    #pass df and svdalgo into rand_pred
    rand_pred(df, svd_pp_cv3)
    
    print ("\nrandom prediction 2:")
    #pass df and svdalgo into rand_pred
    rand_pred(df, svd_pp_cv3)
    
    seconds = (time.time() - start_time)
    minutes = int(seconds)/60
    
    # output code run in seconds and minutes
    print("\nCode output runtime:")
    print("time elapsed in seconds: %s" % seconds)
    print("time elapsed in minutes: %s" % minutes)
    
    # request top 5 prodID to be recommended 
    # pass userID, dataframe, train_set, algo and n_count of top items
    topReco_prod = recommendations('A17HMM1M7T9PJ1', df, train_set, svd_pp_cv3, 5)
    
    print ("\nRecommendation for 'A17HMM1M7T9PJ1': ")
    
    #print out the top recommended items
    for prod in topReco_prod[0:]:
        print (prod)
    
    print("\n=============== End of Program ===============\n")

# a random function to select the uid and iid
def rand_pred(df, svdalgo):
    rand1 = np.random.randint(0 ,len(df))
    
    print ("df custID: ", df.at[df.index[rand1],'userID'])
    
    rand2 = np.random.randint(0 ,len(df))

    print ("df prodID: ", df.at[df.index[rand2],'prodID'])
    
    pred2 = svdalgo.predict(uid=df.at[df.index[rand1],'userID'], iid=df.at[df.index[rand2],'prodID'], r_ui=None).est
    
    print("rating prediction: ", round(pred2))

# provide recommendations of prodID
def recommendations(userID, df, train_set, algo, n_count): 
    # get the list of all item IDs in the dataset
    itemIDs = list(train_set.all_items())

    # get the predicted ratings for each item for the given userID
    predictions = defaultdict(float)
    for itemID in itemIDs:
        predictions[itemID] = algo.predict(userID, itemID).est

    # sort the predictions by rating and extract the top n recommended item IDs
    top_n = sorted(predictions.items(), key=lambda x: x[1], reverse=True)[:n_count]
    top_itemIDs = [train_set.to_raw_iid(itemID) for itemID, rating in top_n]

    # get the names of the recommended items
    item_names = df.loc[df["prodID"].isin(top_itemIDs), "prodID"].drop_duplicates().tolist()

    # create a list of dictionaries containing the recommended item IDs and names
    top_items = [{"num": i+1, "prodID": item_names[i]} for i, itemID in enumerate(top_itemIDs)]
    
    return top_items

# run start function
start()