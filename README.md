# CSV インポート　プラグイン
このライブラリは、Wordpressの指定テーブルへCSVデータを投入するひな形です。
## インストール方法
Wordpressのプラグインディレクトリへこのパッケージをアップロードしてください。<br />
ZIP圧縮ファイルとして、プラグインインストールを利用してもよいです。
```
csv-import-original-method.zip
```
## 動作環境
PHP 7.1～

このメソッドはPHPからWordpressライブラリを利用してデータベースへCSVデータを送信するメソッドです。
## 使い方
プラグインのファイルでCSVから設定したいテーブルとフィールド設置します。<br>
```php
function insert_payment_records($data) {
    global $wpdb;

    $table_name = $wpdb->prefix . "table_name";

    $mail = sanitize_text_field($data[9]);
    $amount = intval($data[12]);
    $capital = sanitize_text_field($data[4]);
    $Brand = sanitize_text_field($data[20]);
    $cardName = sanitize_text_field($data[19]);

    $wpdb->insert(
        $table_name,
        [
            'mail' => $mail,
            'Amount' => $amount,
            'capital' => $capital,
            'Brand' => $Brand,
            'Name' => $cardName,
            'created' => date('Y-m-d H:i:s'),
        ]
    );
}
```

### タイムアウトについて
通信をする実行環境の通信速度によってはHTTP通信時にタイムアウトが発生する可能性があります。<br />
何度も同じような現象が起こる際は、サーバーの接続の調整もしくは`HTTPクライアントの明示的な指定`からHTTPクライアントの指定及びタイムアウトの時間を増やして、再度実行してください。

### 使用サイト
ライトセンド株式会社 [lightscend.co.jp](https://lightscend.co.jp)
