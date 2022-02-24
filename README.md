# たびシェア
## 概要
本アプリは、「旅に特化したSNSアプリ」です。    
投稿者は文章や写真とともに、旅のジャンル（アウトドア、グルメなど）や旅先の都道府県を投稿することができます。	    
閲覧者は全投稿を一覧で見られるほか、いいねの押下やキーワード検索なども可能です。 

## 作成した背景/目的
私は旅行を趣味としており、旅先の写真や経験をSNSアプリに投稿し、思い出として記録しています。     
また、SNSアプリで他の人の旅の投稿を見て、疑似的に楽しんだり自身の旅行計画に反映させることもあります。    

しかしながら、現在普及しているSNSアプリは様々なジャンルの情報が錯綜しており、整理をつけるのが難しくなっています。    
一方で、旅を記録するアプリ自体は既にありますが、SNSのように気軽に投稿できるものはあまりないと感じました。    

そこで、本アプリは旅に特化させることでこれらの問題の解決し、旅という非日常を自他ともに楽しめるような場の構築を目指します。    

## 開発環境
* Windows10
* HTML/CSS　Bootstrap　Vue.js
* PHP　Laravel
* MariaDB　MySQL
* AWS（Cloud9, S3）
* Google APIs（OAuth 2.0 認証, Maps Javascript API）
* Github（https://github.com/ef190010/SNS）
* Heroku（https://morning-river-34886.herokuapp.com）

## 注力した機能
1．コメント機能
* 投稿詳細画面でコメントの作成・一覧を完結させ、使いやすさを意識しました。    
* コメントに対するコメントも可能にしました。    
![image](https://user-images.githubusercontent.com/94438712/155583441-f63f78d9-15eb-4652-a180-e46b1e1a897a.png)
![image](https://user-images.githubusercontent.com/94438712/155583459-4b66e188-26c6-42d4-983a-824fa23bfd7a.png)

2．タグ機能
* 多対多のリレーションを組み、投稿作成でタグが入力されるとtagsテーブルに入るようにしました。
* 入力フォーム内で「#」で区切ることでタグの分割を可能にしました。     
![image](https://user-images.githubusercontent.com/94438712/155583698-35cac926-1fe7-4626-8e85-98e383d24588.png)
![image](https://user-images.githubusercontent.com/94438712/155583708-b40ea08d-abc8-4e6a-81ae-a8fa27449a3a.png)

3．ジャンル選択機能・都道府県選択機能
* Configフォルダ内にphpファイルを作り、連想配列として扱いました。    
* DBの数が減り、複雑さが多少改善しました。    
(スクリーンショット準備中)

<p align="center">
    <img src="" title="" width="80%">
</p>


## テーブル定義
#### ※工事中
#### usersテーブル
|  カラム名  |  データ型  |  詳細  |
| ---- | ---- | ---- |
|  id  |  bigint(20) unsigned  |  ID  |
|  name  |  varchar(255)  |  アカウント名  |
|  password  |  varchar(255)  |  パスワード  |
|  rememberToken  |  varchar(100)  |  ログイン状態を保持  |
|  nickname  |    |  ニックネーム  |
|  icon  |    |  アイコン画像  |
|  category  |    |  投稿のカテゴリー  |
|  pref  |    |  都道府県  |
|  created_at  |  timestamp  |  データ作成時刻  |
|  updated_at |  timestamp  |  データ更新時刻  |
|  deleted_at  |  timestamp  | データ消去時刻  |

