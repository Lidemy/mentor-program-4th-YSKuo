
## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫

### 雜湊跟加密的差別
加密和雜湊兩者概念不一樣

|      | input to output | output 可否還原          | 適用情形  |
| ---- | -------------- | ----------------------- | -------  |
| 加密  | 一對一          | output 可被解密回 input   | 訊息傳遞  |
| 雜湊  | 多對一          | output 不可還原成 input   | 密碼驗證  |

### 密碼沒雜湊的風險
沒有經過加密或雜湊的資訊叫做明文（又稱明碼）

> 1. 如果有駭客駭進了網站資料庫的主機，那所有使用者的帳號、密碼都赤裸裸地攤在駭客的眼前，每個人的帳戶、個人資料都無法倖免。
> 2. 如果網站管理者居心不良、或是受到威脅、或是起來上廁所時忘了切換電腦畫面，那使用者的帳號、密碼隨時都可能外洩。 - [CodingCoke](https://medium.com/@brad61517/%E8%B3%87%E8%A8%8A%E5%AE%89%E5%85%A8-%E5%AF%86%E7%A2%BC%E5%AD%98%E6%98%8E%E7%A2%BC-%E6%80%8E%E9%BA%BC%E4%B8%8D%E7%9B%B4%E6%8E%A5%E5%8E%BB%E8%A3%B8%E5%A5%94%E7%AE%97%E4%BA%86-%E6%B7%BA%E8%AB%87-hash-%E7%94%A8%E9%9B%9C%E6%B9%8A%E4%BF%9D%E8%AD%B7%E5%AF%86%E7%A2%BC-d561ad2a7d84)

> 1. 傳輸的過程中若被監聽，攻擊者將可以直接取得你的密碼。
> 2. 若伺服器遭到入侵，所有站上的帳號密碼都將被攻擊者取得。 - [我的密碼沒加密](https://plainpass.com/2011/11/never-save-your-password-in-plaintext.html)

## `include`、`require`、`include_once`、`require_once` 的差別
* `include`
  * 可引用其他的 php 檔進來
* `require`
  * 和 `include` 一樣可引入 php 檔
* `include` 和 `require` 兩者最大的差別
  * `require` 在發生錯誤的時候，會停止程式的運作，而 `include` 則僅會產生一個 Warning，卻繼續執行之後的程式碼
* `include_once`
  * 當引入的文件重覆時，`include` 依然會重覆的將文件加入自己的文件中，而 `include_once` 則不會這麼做，就像 once 的意思那樣，只會引入一次而已。
* `require_once`
  * 和 `require` 的差別是 `require_once` 在為主體 PHP 檔案包含進來的檔案僅能一次，不會重覆包含進來

## 請說明 SQL Injection 的攻擊原理以及防範方法
### SQL Injection
```
攻擊者熟知 SQL 語法並利用語法特性來注入到目標資料庫，又稱駭客的填字遊戲。
```

##### 範例
原本正常 SQL 指令
```sql
INSERT INTO comments(nickname, content) VALUES('%s', '%s');
```

其中兩個 `%s` 都是讓使用者輸入字串的欄位，若使用者不懷好意而將 content 欄位寫入 `echo SELECT * FROM username; ?>#`

那 SQL 指令會變成

```sql
INSERT INTO comments(nickname, content) 
VALUES('%s', ''echo SELECT * FROM username; ?>#');
```

`#` 後面的 code 會被認成註解，這樣就會把所有 username 的資料都撈出來

##### 另個範例
```sql
aaa
comment = select username from YSKuo_username'), ("Obama", "who am I");
```

```
解法：使用 Prepare Statement
```

### Prepared Statement
```
用途：針對 SQL Injection 的防禦手段 
```

##### 範例
`handle_login.php` 截取字串處理的部分
```php
<?php
  // ...
  
  $sql = "SELECT * FROM users WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    header("Location: login.php?errCode=2");
    exit();
  }
  
  // ...
?>
```

顯示留言的部分也要更改

```
再次提醒，永遠對於使用者資料輸入進行字元有效性檢查
```

##### 參考
1. [PHP - Prepared Statements](https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php)
1. [為什麼用Prepared Statement還會有SQL injection?](https://www.qa-knowhow.com/?p=4172)

##  請說明 XSS 的攻擊原理以及防範方法
### XSS
*(**C**ross-**S**ite **S**cripting)*

```
在別人的網頁上執行 JavaScript，因此可以做到
1. 篡改頁面
2. 篡改連結
3. 偷取 Cookie
```

##### 範例
在 comment 處留下
```htmlmixed
<script>alert("hacked");</script>
<script>location.href="https://google.com"</script>
<script>

document.cookie
</script>
```
 
```
解法：
使用 escape
- PHP： `htmlspecialchars($str, ENT_QUOTES, 'utf-8');`
```

### htmlspecialchars

```
用途：將 HTML 認成特殊字元的內容轉換成一般字串，以防範他人使用 XSS
語法：`htmlspecialchars($str, ENT_QUOTES, 'utf-8');`
```

```
使用者可以輸入的內容(帳號、暱稱、留言)一律 escape！
```

##### 參考
- [PHP - htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php)

## 請說明 CSRF 的攻擊原理以及防範方法

### 原理
利用瀏覽器的特性可使發送 request 到某 domain 時把相關的 cookie 給戴上，進而造成在不同的 domain 可偽造出使用者本人發出的 request 的效果。

##### 範例
```
<iframe style="display:none" name="csrf-frame"></iframe>
<form method='POST' action='https://small-min.blog.com/delete' target="csrf-frame" id="csrf-form">
  <input type='hidden' name='id' value='3'>
  <input type='submit' value='submit'>
</form>
<script>document.getElementById("csrf-form").submit()</script>
```
> 開一個看不見的 iframe，讓 form submit 之後的結果出現在 iframe 裡面，而且這個 form 還可以自動 submit，完全不需要經過小明的任何操作。

### 防範方法
思考方式該以『如何擋掉從別的 domain 發送來的 request？』

#### 檢查 Referer
- 檢查 request 的 header 中 referer 欄位是否為合法 domain
- 三個缺點：
  1. 某些 browser 不見得會帶 referer 
  2. user 或許關閉自帶 referer 功能
  3. 判斷是否為合法 domain 的 code 可能會有 bug
```
const referer = request.headers.referer;
if (referer.indexOf('small-min.blog.com') > -1) {
  // pass
}
```
- 結論：不夠完善

#### 加上驗證機制（圖形、簡訊）
- 類似網銀轉帳一樣使用簡訊驗證碼
- 結論：防禦性佳但對使用者不夠體貼

#### 加上 CSRF token
- 在 form 裡加一個 hidden 欄位帶 csrftoken，該值由 server 產生並存在 session 裡；submit 後 比對 csrftoken 以驗證是否是 user 本人發出
```
<form action="https://small-min.blog.com/delete" method="POST">
  <input type="hidden" name="id" value="3"/>
  <input type="hidden" name="csrftoken" value="fj1iro2jro12ijoi1"/>
  <input type="submit" value="刪除文章"/>
</form>
```
- 缺點：若 server 接受 cross origin 的 request 則破功
- 結論：此解應該算堪用只是仍有破綻

#### Double Submit Cookie
- 與 CSRF 相似，都是由 server 產生 random token 然後加到 form；不同點在不用把此值寫在 session 裡，且讓 client 端設定一個 csrftoken 的 cookie
```
Set-Cookie: csrftoken=fj1iro2jro12ijoi1

<form action="https://small-min.blog.com/delete" method="POST">
  <input type="hidden" name="id" value="3"/>
  <input type="hidden" name="csrftoken" value="fj1iro2jro12ijoi1"/>
  <input type="submit" value="刪除文章"/>
</form>
```
- 缺點：subdomain 可能成為漏洞

#### client side 的 Double Submit Cookie
- 由 client 端來生成 csrf token，不用跟 server api 有任何的互動
- token 生成後一樣放到 cookie 和 form 裡面，甚至可以放到 request header 中
- axios 這個 library 就有自動在 header 填上 cookie 的功能
```
 // `xsrfCookieName` is the name of the cookie to use as a value for xsrf token
xsrfCookieName: 'XSRF-TOKEN', // default

// `xsrfHeaderName` is the name of the http header that carries the xsrf token value
xsrfHeaderName: 'X-XSRF-TOKEN', // default
```
- Double Submit Cookie 的核心概念是：「攻擊者的沒辦法讀寫目標網站的 cookie，所以 request 的 csrf token 會跟 cookie 內的不一樣」

#### browser 本身的防禦
- Google Chrome 的 SameSite cookie 功能，只要在 header 中設定 cookie 的部分加上 `SameSite` 就行
```
Set-Cookie: session_id=ewfewjf23o1; SameSite
```
- 預設為 `Lax` 模式，讓 <a>, <link>, <form method="GET"> 等 tag 都會帶上 cookie，但使用 POST, PUT, DELETE 等方法的 <form> 都不會帶上 cookie
- 缺點：須考慮瀏覽器支援度
