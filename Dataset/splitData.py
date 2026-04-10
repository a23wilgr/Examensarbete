import pandas as pd

df = pd.read_csv("articles_dataset.csv")

df_30k = df.iloc[:30000]
df_60k = df.iloc[:60000]
df_92k = df.iloc[:92000]

df_30k.to_csv("articles_30k.csv", index=False)
df_60k.to_csv("articles_60k.csv", index=False)
df_92k.to_csv("articles_92k.csv", index=False)