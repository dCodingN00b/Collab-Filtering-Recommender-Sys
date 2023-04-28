from surprise import accuracy, Dataset, Reader, SVDpp
from surprise.model_selection import GridSearchCV, cross_validate, train_test_split
from collections import defaultdict
import pandas as pd
import numpy as np
import re
import sys
import os

def rename_ID(x):
    if len(x)>10:
        return "userID"
    if 4 <= len(x) <= 12:
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
        # check whether there are 7 different arguments
        if len(sys.argv) != 8:
            print("Usage: python svdpp_inputs_4csv.py <src filepath1> <src filepath2> <src filepath3> <src filepath4> <userID> <prodID> <no of recommendation>")
            sys.exit(1)
        
        # specify filepaths from arguments
        arg_filepath1 = sys.argv[1]
        arg_filepath2 = sys.argv[2]
        arg_filepath3 = sys.argv[3]
        arg_filepath4 = sys.argv[4]
        
        # specify userID, prodID, no_of_reco from arguments
        arg_userID = sys.argv[5]
        arg_prodID = sys.argv[6]
        arg_no_of_reco = sys.argv[7]
        
        # Select the CSV files from the source folders
        csv_files = []
        for folder in [arg_filepath1, arg_filepath2, arg_filepath3, arg_filepath4]:
            for file in os.listdir(folder):
                if file.endswith('.csv'):
                    csv_files.append(os.path.join(folder, file))
        
        # Initialize empty dataframe to store merged data
        merged_df = pd.DataFrame()
        # Copy the CSV files to the destination folder
        for csv_file in csv_files:
            df = pd.read_csv(csv_file)
            # if dataframe is not empty
            if not df.empty:
                merged_df = pd.concat([merged_df, df])
        
        # make the merged_df to df
        df = merged_df
                
        # overwrite the userID column with the extracted value
        df['userID'] = df['userID'].apply(lambda x: extract_user_id(x))
        
        # drop null values in dataframe
        df = df.dropna()
        
        #drop duplicates
        df = df.drop_duplicates()
        
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
            df = df.sample(10000)
        # else if sample at 1k
        elif (df_shape[0]>1000):
            df = df.sample(1000)
                
        # reader to read data
        reader = Reader()
        
        #svd++ algo
        svdppcv3_gs(df, reader, arg_userID, arg_prodID, arg_no_of_reco)
        
    except Exception as e:
        print ("Exception: ", e)
             
        # exit the program
        exit()

def svdppcv3_gs(df, reader, arg_userID, arg_prodID, no_of_reco):    
    # use load_from_df to load userID, prodID, rating
    data = Dataset.load_from_df(df[['userID', 'prodID', 'rating']], reader)
    
    # build trainset from data
    train_set = data.build_full_trainset()
    
    # build testset from trainset
    data_testset = train_set.build_testset()
    
    # normal svdpp
    svdppalgo = SVDpp()
    
    # fit trainset
    svdppalgo.fit(train_set)
    
    # trainset on testset
    test_Pred = svdppalgo.test(data_testset)
    
    # Then compute RMSE
    rmseVal_ori = accuracy.rmse(test_Pred, verbose=False)
    
    # hyperparameters 
    param_grid = {"n_factors": [15, 20], 
                  "n_epochs": [20, 40, 60], 
                  "lr_all": [0.002, 0.004, 0.007], 
                  "reg_all": [0.02, 0.04, 0.07] 
                  } 
    
    # run GridsearchCV
    gs_cv3 = GridSearchCV(SVDpp, param_grid, measures=["rmse", "mae"], cv=3, n_jobs=-1)
    
    # fit dataset
    gs_cv3.fit(data)
    
    # to put the best values into the svd algo
    svd_pp_cv3 = gs_cv3.best_estimator["rmse"]
    
    # fit trainset
    svd_pp_cv3.fit(train_set)
    
    # test the algorithm on the testset
    bestpred_cv3 = svd_pp_cv3.test(data_testset)
    
    # Then compute RMSE
    rmseVal_cv = accuracy.rmse(bestpred_cv3, verbose=False)
    
    print ("\n=============== Compare and run prediction ===============")
    # compare if rmseVal_cv more than rmseVal_ori, we will use original base SVD++ parameters and run the prediction
    if (rmseVal_cv>rmseVal_ori):
        # print rmse for normal svdpp
        print("\nRMSE for trainset on testset for normal svdpp:", round(rmseVal_ori, 4))
        
        # run svdpp using predict function
        norm_pred = svdppalgo.predict(uid=arg_userID, iid=arg_prodID, r_ui=None).est
        
        # print out the rounded prediction for the userID and prodID
        print (f"\nrating prediction for {arg_userID} on prodID = {arg_prodID}: {round(norm_pred)}")
        
        # pass userID, dataframe, train_set, algo and n_count of top items
        topReco_prod = similar_products(arg_prodID, df, train_set, svdppalgo, int(no_of_reco))
        
        print (f"\nRecommendation for {arg_prodID}: ")
        
        # print out the top recommended items
        for prod in topReco_prod[0:]:
            print (prod)
        
    # compare if rmseVal_ori more than rmseVal_cv, we will use tuned SVD++ parameters and run the prediction 
    elif (rmseVal_ori>rmseVal_cv):
        # print rmse for tuned svdpp
        print("\nRMSE for trainset on testset for tuned svdpp:", round(rmseVal_cv, 4))
        
        # run svdpp using predict function
        norm_pred = svdppalgo.predict(uid=arg_userID, iid=arg_prodID, r_ui=None).est
        
        # print out the rounded prediction for the userID and prodID
        print (f"\nrating prediction for {arg_userID} on prodID = {arg_prodID}: {round(norm_pred)}")
        
        # pass userID, dataframe, train_set, algo and n_count of top items
        topReco_prod = similar_products(arg_prodID, df, train_set, svd_pp_cv3, int(no_of_reco))
        
        print (f"\nRecommendation for {arg_prodID}: ")
        
        # print out the top recommended items
        for prod in topReco_prod[0:]:
            print (prod)
    
    print("\n===================== End of Program =====================\n")

def similar_products(prodID, df, train_set, algo, n_count): 
    # get the list of all item IDs in the dataset
    itemIDs = list(train_set.all_items())

    # get the predicted ratings for each item for the userID = 0
    predictions = defaultdict(float)
    for itemID in itemIDs:
        predictions[itemID] = algo.predict(uid=0, iid=itemID).est

    # sort the predictions by rating and extract the top n recommended item IDs
    top_n = sorted(predictions.items(), key=lambda x: x[1], reverse=True)
    top_itemIDs = [train_set.to_raw_iid(itemID) for itemID, rating in top_n if train_set.to_raw_iid(itemID) != prodID][:n_count]
    
    # get the names of the recommended items and drop drop duplicates
    item_names = df.loc[df["prodID"].isin(top_itemIDs), "prodID"].drop_duplicates().tolist()

    # create a list of dictionaries containing the recommended item IDs and names
    top_items = [{"num": i+1, "prodID": item_names[i]} for i, itemID in enumerate(top_itemIDs)]
    
    return top_items

# run start function
start()