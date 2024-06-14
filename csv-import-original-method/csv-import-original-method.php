<?php

function custom_db_import_menu() {
    add_menu_page(
        'test CSVインポート', // ページタイトル
        'test CSVインポート', // メニュータイトル
        'manage_options', // 権限
        'gayo_test_custom-db-import', // スラッグ
        'custom_db_import_page', // コールバック関数
        'dashicons-upload', // アイコン
        20 // メニューの位置
    );
}
add_action('admin_menu', 'custom_db_import_menu');

function custom_db_import_page() {
    if (isset($_POST['submit']) && !empty($_FILES['csv_file']['tmp_name'])) {
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, 'r');
        if ($handle !== false) {
            // ヘッダーを読み飛ばす
            fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                insert_payment_records($data);
            }
            fclose($handle);
            echo '<div class="updated"><p>CSVファイルのインポートが完了しました。</p></div>';
        }
    }

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">CSVファイルのインポート</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv">
            <input type="submit" name="submit" value="インポート" class="button button-primary">
        </form>
    </div>
    <?php
}

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