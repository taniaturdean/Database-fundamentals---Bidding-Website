import numpy
import pandas as pd
import mysql.connector as mysql
import sys

user_id=int(sys.argv[1])

def add_recommendations(data):
    sql = "UPDATE users SET rec1=%s, rec2=%s, rec3=%s WHERE user_id = %s"
    cur.executemany(sql, data)
    db.commit()

try:
    MY_HOST = 'localhost'
    MY_USER = 'root'
    MY_PASS = 'Constantinople1452'
    db = mysql.connect(host=MY_HOST, user=MY_USER, password=MY_PASS, database='auction')
    cur = db.cursor(buffered=True)

    query = """SELECT b.bid_id, i.category_id, b.timestamp, b.bid_price, b.user_id FROM bids b, items i WHERE i.item_id = b.item_id;"""
    cur.execute(query)
    records = cur.fetchall()
    mbids = pd.DataFrame(records, columns=['bid_id','category_id','timestamp','bid_price','user_id'])

    buyers = mbids.user_id.unique()

    categories = [1,2,3,4,5,6]
    weights = []

    for buyer in buyers:
        a = mbids.loc[mbids.user_id==buyer]
        for cat in categories:
            weights.append([buyer,cat,list(a.category_id).count(cat)])

    weights = pd.DataFrame(weights, columns=['user_id','category_id','number_of_bets'])
    df = weights.pivot_table(index = 'user_id', columns = 'category_id', values='number_of_bets')

    similars = []
    r_a = df.loc[df.index == user_id].values.tolist()[0]
    r_a_mean = sum(r_a)/len(r_a)
    for x in [x for x in buyers if x != user_id]:
        r_b = df.loc[df.index == x].values.tolist()[0]
        r_b_mean = sum(r_a)/len(r_a)

        numerator = sum([(r_a[i-1]-r_a_mean)*(r_b[i-1]-r_b_mean) for i in categories])
        denominator = sum([(r_a[i-1]-r_a_mean)**2 for i in categories])**0.5*sum([(r_b[i-1]-r_b_mean)**2 for i in categories])**0.5
        try:
            similars.append((x,numerator/denominator))
        except:
            continue

    score = []
    for i in categories:
        item = i-1
        numerator = sum([j*df.loc[df.index == i].values.tolist()[0][item] for i,j in similars])
        denominator = sum([abs(j) for i,j in similars])
        try:
            score.append((i,r_a_mean + numerator/denominator))
        except:
            continue
    
    score.sort(key = lambda x: x[1])

    data = [(score[-1][0],score[-2][0],score[-3][0],int(user_id))]
    
    add_recommendations(data)
    cur.close()
    db.close()
except:
    print("Error in collaborative filtering")