## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼

* `VARCHAR`
  * 可設最大長度以及 DEFAULT
  * 適合用在長度可變的資料
  * 查詢速度較 `TEXT` 快
* `TEXT`
  * 不可設長度和 DEFAULT
  * 不知道資料最大長度時適合用

## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？

Cookie 是一種「小型文字檔案」，某些網站為了辨別用戶身分而儲存在用戶端（Client Side）上的資料（通常經過加密）。
Server 端回傳 Response 時要求瀏覽器（SetCookie）在 Cookie 放入 SessionID，瀏覽器發出 Request 時在 Request Header 帶上 Cookie 一起送給 Server 端。

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？

* 使用者發送的內容沒有 escape，所以容易被 HTML 或 PHP 認為是指令（標籤）
* 密碼沒有加密，只要資料外洩就容易讓他人登入會員

