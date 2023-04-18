from surprise import accuracy, Dataset, Reader, SVDpp
from surprise.model_selection import GridSearchCV, cross_validate, train_test_split
from collections import defaultdict
import pandas as pd
import numpy as np
import time
import re
import sys

def rename_ID(x):
    if len(x)>10:
        return "userID"
    if len(x)==10:
        return "prodID"
    if x=='5.0' or x=='4.0' or x=='3.0' or x=='2.0' or x=='1.0':
        return "rating"
    return x

# define the lambda function to extract the userID
def extract_user_id(href):
    if re.search(r'amzn1\.account\.(\w+)', href):
        return re.search(r'amzn1\.account\.(\w+)', href).group(1)

def start():
    try:
        if len(sys.argv) != 2:
            print("Usage: python svdpp_csv_reco.py <prodID>")
            sys.exit(1)
        
        arg_prodID = sys.argv[1]
        
        #read in data from .csv file
        df = pd.read_csv('videogames_out.csv')
        
        # RandomState(0) to ensure that the result yield the same results
        rng = np.random.RandomState(0)
        
        # overwrite the userID column with the extracted value
        df['userID'] = df['userID'].apply(lambda x: extract_user_id(x))
        
        print("is any of the variables null values?\n", df.isnull().sum())
        
        print("we will use dropna to drop the null values before running SVDpp")
        
        # drop null values in dataframe
        df = df.dropna()
        
        #drop duplicates
        df = df.drop_duplicates()
        
        # display dataframe info
        df.info()
        
        print("\nis any of the variables null values?\n", df.isnull().sum())
        
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
        
        print("\nSpread of ratings after sampling:")
        print("ratings 1: ", len(df[df.rating==1]))
        print("ratings 2: ", len(df[df.rating==2]))
        print("ratings 3: ", len(df[df.rating==3]))
        print("ratings 4: ", len(df[df.rating==4]))
        print("ratings 5: ", len(df[df.rating==5]))
        
        # reader to read data
        reader = Reader()
        
        #svd++ algo
        print ("\n================== svdpp algo ==================\n")
        svdppcv3_gs(df, reader, rng, arg_prodID)
        
    except Exception as e:
        print ("Exception: ", e)
             
        # exit the program
        exit()

def svdppcv3_gs(df, reader, rng, arg_prodID):    
    print("put dataset of 'userID', 'prodID', 'rating' parameters to load into df")
    
    # finding time taken for code to run
    start_time = time.time()
    
    print ("\nFor testing purposes to show the correct selection")
    data = Dataset.load_from_df(df[['userID', 'prodID', 'rating']], reader)
    # build trainset from data
    train_set = data.build_full_trainset()
    
    # build testset from trainset
    data_testset = train_set.build_testset()
    
    # normal svdpp
    svdppalgo = SVDpp()
    
    svdppalgo.fit(train_set)
    
    # trainset on testset
    test_Pred = svdppalgo.test(data_testset)
    
    # Then compute RMSE
    rmseVal_ori = accuracy.rmse(test_Pred, verbose=False)
    
    print("\nRMSE for trainset on testset for normal svdpp:", round(rmseVal_ori, 4))
            
    print ("\n============ Tuned svdpp ============\n")
    
    # hyperparameters
    param_grid = {"n_factors": [15, 20], 
                  "n_epochs": [20, 40, 60], 
                  "lr_all": [0.002, 0.004, 0.007], 
                  "reg_all": [0.02, 0.04, 0.07]
                  } 
    
    print ("running GridSearchCV with cv=3 and n_jobs=-1 which will enable all cpu cores")
    
    gs_cv3 = GridSearchCV(SVDpp, param_grid, measures=["rmse", "mae"], cv=3, n_jobs=-1)
    
    gs_cv3.fit(data)
    
    # best RMSE score
    print("Best GS cv=3 RMSE: ", gs_cv3.best_score["rmse"])
    
    # combination of parameters that gave the best RMSE score
    print("\nBest parameters obtained by gridsearchCV:", gs_cv3.best_params["rmse"])
    
    # to put the best values into the svd algo
    svd_pp_cv3 = gs_cv3.best_estimator["rmse"]
    
    # fit trainset
    svd_pp_cv3.fit(train_set)
    
    # test the algorithm on the testset
    bestpred_cv3 = svd_pp_cv3.test(data_testset)
    
    # Then compute RMSE
    rmseVal_cv = accuracy.rmse(bestpred_cv3, verbose=False)
    
    print("\nRMSE for trainset on testset for tuned svdpp:", round(rmseVal_cv, 4))
    
    print ("\n=============== Compare and run prediction ===============")
    # compare if rmseVal_cv more than rmseVal_ori, we will use original base SVD++ parameters and run the prediction
    if (rmseVal_cv>rmseVal_ori):
        # print rmse for normal svdpp
        print("\nRMSE for trainset on testset for normal svdpp:", round(rmseVal_ori, 4))
        
        # request top 5 prodID to be recommended 
        # pass userID, dataframe, train_set, algo and n_count of top items
        topReco_prod = similar_products(arg_prodID, df, train_set, svdppalgo, 5)
        
        print (f"\nRecommendation for {arg_prodID}: ")
        
        # print out the top recommended items
        for prod in topReco_prod[0:]:
            print (prod)
        
    # compare if rmseVal_ori more than rmseVal_cv, we will use tuned SVD++ parameters and run the prediction 
    elif (rmseVal_ori>rmseVal_cv):
        # print rmse for tuned svdpp
        print("\nRMSE for trainset on testset for tuned svdpp:", round(rmseVal_cv, 4))
                
        # request top 5 prodID to be recommended 
        # pass userID, dataframe, train_set, algo and n_count of top items
        topReco_prod = similar_products(arg_prodID, df, train_set, svd_pp_cv3, 5)
        
        print (f"\nRecommendation for {arg_prodID}: ")
        
        # print out the top recommended items
        for prod in topReco_prod[0:]:
            print (prod)
    
    print("\n===================== End of Program =====================\n")

def rand_pred(df, svdalgo):
    rand1 = np.random.randint(0 ,len(df))
    
    print ("df custID: ", df.at[df.index[rand1],'userID'])
    
    rand2 = np.random.randint(0 ,len(df))

    print ("df prodID: ", df.at[df.index[rand2],'prodID'])
    
    pred2 = svdalgo.predict(uid=df.at[df.index[rand1],'userID'], iid=df.at[df.index[rand2],'prodID'], r_ui=None).est
    
    print("rating prediction: ", round(pred2))

def similar_products(prodID, df, train_set, algo, n_count): 
    # get the list of all item IDs in the dataset
    itemIDs = list(train_set.all_items())

    # get the predicted ratings for each item for the userID = 0
    predictions = defaultdict(float)
    for itemID in itemIDs:
        predictions[itemID] = algo.predict(uid=0, iid=itemID).est

    # sort the predictions by rating and extract the top n recommended item IDs
    top_n = sorted(predictions.items(), key=lambda x: x[1], reverse=True)
    top_itemIDs = [train_set.to_raw_iid(itemID) for itemID, rating in top_n if itemID != prodID][:n_count]

    # get the names of the recommended items
    item_names = df.loc[df["prodID"].isin(top_itemIDs), "prodID"].drop_duplicates().tolist()

    # create a list of dictionaries containing the recommended item IDs and names
    top_items = [{"num": i+1, "prodID": item_names[i]} for i, itemID in enumerate(top_itemIDs)]
    
    return top_items

# run start function
start()