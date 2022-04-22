# たびシェア
## 概要
本アプリは、「旅に特化したSNSアプリ」です。    
投稿者は文章や写真とともに、旅のジャンル（アウトドア、グルメなど）や旅先の都道府県、位置情報を投稿することができます。	    
閲覧者は全投稿を一覧で見られるほか、いいねの押下やキーワード検索なども可能です。 
<img src="https://user-images.githubusercontent.com/94438712/155878671-aa5cc881-98af-45c7-ab78-f37b78c1e30e.png" width="80%">

## 作成した背景/目的
私は旅行を趣味としており、旅先の写真や経験をSNSアプリに投稿し、思い出として記録しています。     
また、SNSアプリで他の人の旅の投稿を見て、疑似的に楽しんだり自身の旅行計画に反映させることもあります。    

しかしながら、現在普及しているSNSアプリは様々なジャンルの情報が錯綜しており、整理をつけるのが難しくなっています。    
一方で、旅を記録するアプリ自体は既にありますが、SNSのように気軽に投稿できるものはあまりないと感じました。    

そこで、本アプリは旅に特化させることでこれらの問題の解決し、旅という非日常を自他ともに楽しめるような場の構築を目指します。    

## 開発環境
* HTML5/CSS3
* Bootstrap v4.6.1
* PHP v8.0.13
* Laravel v6.20.44
* MariaDB v10.2.38
* AWS（Cloud9, EC2, S3）
* Google APIs（OAuth 2.0 認証, Maps Javascript API）
* Github：https://github.com/ef190010/SNS
* Heroku：https://morning-river-34886.herokuapp.com/login

## 機能一覧
* 認証機能
* API認証機能（Google OAuth 2.0）
* ユーザー情報設定・編集機能
* ユーザーフォロー機能
* 投稿機能（CRUD）
* 位置情報機能（GoogleMaps API）
* 返信(コメント)機能（CRUD）
* いいね機能
* 検索機能
* ページネーション機能

## 注力した機能
1．投稿詳細画面・コメント機能
* 投稿詳細画面でコメントの作成・一覧を完結させ、使いやすさを意識しました。  
* コメントに対するコメントも可能にしました。    
<img src="https://user-images.githubusercontent.com/94438712/155876297-6b39f786-841d-4cb2-bf5e-1f1290573f4b.png" width="50%"><img src="https://user-images.githubusercontent.com/94438712/155876302-734dd188-6fe2-4154-8206-57816f504a64.png" width="50%">

2．タグ機能
* 多対多のリレーションを組み、投稿作成でタグが入力されるとtagsテーブルに入るようにしました。
* 入力フォーム内で「#」で区切ることでタグの分割を可能にしました。     
<img src="https://user-images.githubusercontent.com/94438712/155876124-d1197308-fed7-46c9-a0d4-bd0f595dccc6.png" width="50%"><img src="https://user-images.githubusercontent.com/94438712/155876718-79dbbdda-6919-4447-aff9-837d82907214.png" width="50%">

3．位置情報機能
* GoogleMaps APIを利用し、投稿時に地図上にピンを刺せるようにしました。編集も可能です。  
* ピンの位置は座標としてDBに保存され、投稿詳細画面ではこれを呼び出してピンを表示しています。
<img src="https://user-images.githubusercontent.com/94438712/155876130-985918af-a224-47a9-afe2-b97f37d737fe.png" width="50%"><img src="https://user-images.githubusercontent.com/94438712/155876693-332087a7-c324-468b-a12c-ecc7d1fcc17b.png" width="50%">

## E-R図
<img src="https://user-images.githubusercontent.com/94438712/155878550-f63729b1-3dd9-4d4d-8578-18444cb0e847.png" width="80%">
