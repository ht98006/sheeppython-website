import pandas as pd
import numpy as np
import matplotlib as mpl
from mpl_toolkits.mplot3d import Axes3D
from matplotlib import cm
import matplotlib.pyplot as plt

mpl.rc("font",family='Heiti TC')
from io import BytesIO
import base64
from lxml import etree
import webbrowser

url = 'https://www.findcar.com.tw/oil.aspx'

dfs = pd.read_html(url)
#print(dfs) 
votes=dfs[0]
votes.drop(['漲跌','高級柴油'],inplace=True,axis=1)   ##刪除兩欄
#print(votes)
'''
Pandas有以下類型的圖可以繪製
柱狀圖df.plot(kind=
折線圖df.plot()'bar')
橫向柱狀圖df.plot(kind='barh')
直方圖df.plot(kind='hist')
KDE圖df.plot(kind='kde')
面積圖df.plot(kind='area')
圓餅圖df.plot(kind='pie')
散佈圖df.plot(kind='scatter')
六角形箱體圖df.plot(kind='hexbin')
箱形圖df.plot(kind='box')
#繪圖(條形圖模式)
#fontsize字體大小
#legend子圖圖例
#figsize圖例大小
df=pd.Series(np.random.randn(1000),index=np.arange(1000))
'''

df=votes.cumsum()
#print(df)


cmp=['#99CCFF', '#CCFFFF', '#6699CC','#006699','#003366']
df.plot(kind='bar', figsize=(20, 5) ,legend=True, fontsize=20, sharex=True,stacked=True,color=cmp, edgecolor='red', linewidth=1)
plt.grid(c='black')
plt.grid(alpha=0.3)
plt.title('2022油價趨勢(柱狀圖)', fontsize=25)
plt.ylabel("油價元/公升", fontsize=20)
plt.xlabel("時間", fontsize=20)
plt.text(0,300,"最低", ha='center',verticalalignment="baseline", fontsize=25,color='red')
plt.text(23, 4700, "最高", ha='center',verticalalignment="baseline", fontsize=25,color='red')
plt.savefig('柱狀圖.png',dpi=300)


df.plot(kind='box',figsize=(20, 5), legend=True)
plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("時間", fontsize=20)
plt.xlabel("油價元/公升", fontsize=20)
plt.savefig('箱形圖.png',dpi=300)

df.plot(kind='area',stacked=True, figsize=(20, 5), legend=True, fontsize=20)
plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("時間", fontsize=20)
plt.xlabel("油價元/公升", fontsize=15)
plt.savefig('面積圖.png',dpi=300)

df.plot(kind='kde',stacked=True, figsize=(20, 5), legend=True, fontsize=20)
plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("時間", fontsize=20)
plt.xlabel("油價元/公升", fontsize=15)
plt.savefig('密度圖.png',dpi=300)

df.plot(kind='barh', figsize=(10, 8), legend=True, fontsize=20)
plt.title('2022油價趨勢', fontsize=20)
plt.ylabel("時間", fontsize=20)
plt.xlabel("油價元/公升", fontsize=20)
plt.savefig('橫向柱狀圖.png',dpi=300)
 
df.plot(kind='hist',stacked=True, figsize=(20, 5), legend=True)
plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("油價元/公升", fontsize=20)
plt.xlabel("時間", fontsize=20)
plt.savefig('直方圖.png',dpi=400)
plt.legend() 



df.plot(kind='hist',stacked=True, figsize=(20, 5), legend=True)
plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("油價元/公升", fontsize=20)
plt.xlabel("時間", fontsize=20)
plt.savefig('直方圖.png',dpi=400)
plt.legend() 



fig = plt.figure(figsize=(10,10))
ax =  plt.axes(projection='3d')
x = np.arange(28, 30, 0.5)
y = np.arange(28, 30, 0.5)
X, Y = np.meshgrid(x, y)
Z = np.sin(X)*np.cos(Y)
surf = ax.plot_surface(X, Y, Z, cmap = plt.cm.cividis)
fig.colorbar(surf, shrink=0.5, aspect=10)
ax.set_title("2022油價趨勢", fontsize=25)
ax.set_xlabel("油價元/公升", fontsize=20)
ax.set_zlabel("時間", fontsize=20)
plt.savefig('立體圖.png',dpi=400)
plt.show()

a = np.array([27.5, 28.6, 29.2,
              31.3,30.5, 30.4]).reshape(3,2)
plt.imshow(a, interpolation='nearest', cmap='bone', origin='lower')
plt.colorbar(shrink=.90)  # 这是颜色深度的标注，shrink表示压缩比例
plt.ylabel("油價元/公升", fontsize=20)
plt.xlabel("時間", fontsize=20)
plt.xticks(())
plt.yticks(())
plt.savefig('油價深淺圖.png',dpi=400)
plt.show()



fig = plt.figure(figsize=(20,10))
# set_facecolor用于設定背景顏色
fig.patch.set_facecolor('#d8ffff')
# set_alpha用于指定透明度
fig.patch.set_alpha(0.9)

month = [1,2,3,4,5,6]
stock_tsmcc = [29.8,30.7,31.2,30.5,30.1,29.5]
stock_foxconnn = [28.4,30.7,31.2,30.5,30.1,29.5]
oila = [29.9,32.2,32.7,32.3,31.7,31.0]
oilb = [31.2,31.6,32.9,32.2,31.7,31.0]
oilc = [33.3,34.2,34.7,34.0,33.6,33.0]
oild = [33.3,34.2,34.7,34.0,33.6,33.0]
plt.plot(month,stock_tsmcc,'s-', label="(92無鉛汽油,中油)",linewidth=4)
plt.plot(month,stock_foxconnn,'o-', label="(92無鋁汽油,台塑)",linewidth=4)
plt.plot(month,oila,'*-', label="(95無鉛汽油,中油)",linewidth=4)
plt.plot(month,oilb,'x-',label="(95無鋁汽油,台塑)",linewidth=4)
plt.plot(month,oild,'k',  label="(98無鋁汽油,台塑)",linewidth=4)
plt.plot(month,oilc,'gd', label="(98無鉛汽油,中油)",linewidth=4)

plt.title('2022油價趨勢', fontsize=25)
plt.ylabel("油價元/公升", fontsize=20)
plt.xlabel("月份/時間", fontsize=20)
plt.grid()

plt.legend(loc = "best", fontsize=20)
# 畫出圖片
plt.savefig('折線圖.png',dpi=400)
plt.show()
