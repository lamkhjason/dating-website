# dating-website
## 必須機能
### 画面
- ログイン画面
- 新規登録画面
- いいね画面
- マッチングした相手一覧画面
- 自分のプロフィール画面
- 自分以外のユーザのプロフィール画面
- プロフィール編集画面

## ファイルツリー
<pre>
.
└── src
    ├── assets
    │   ├── css
    │   │   └── Style.css
    │   └── icon
    ├── components
    │   ├── CheckValue.php
    │   └── CommonTools.php
    ├── database
    │   ├── LoginStatus.php
    │   ├── Pdo.php
    │   ├── ProcessInteractions.php
    │   ├── ProcessLogin.php
    │   ├── ProcessRegister.php
    │   ├── SelectInteractions.php
    │   ├── SelectMatchedList.php
    │   ├── SelectProfileItem.php
    │   └── UpdateEditProfile.php
    ├── js
    │   └── Congratulations.js
    └── pages
        ├── EditProfile.php
        ├── Interactions.php
        ├── Login.php
        ├── MatchedList.php
        ├── Profile.php
        └── Register.php
</pre>

## ブランチ
ブランチ名は以下のルールに沿って作ってください
- 新機能：feature/ブランチの内容
- バグ修正：fixbug/ブランチの内容

## レビュー
基本最低１人のapproveが必要です。<br>
PR後、コーディング部屋にレビュー依頼する。
